<?php

namespace App\Http\Controllers\Web;

use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Crazymeeks\Foundation\PaymentGateway\Dragonpay;
use Crazymeeks\Foundation\Exceptions\PaymentException;
use Crazymeeks\Foundation\PaymentGateway\DragonPay\Action\CancelTransaction;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\ServicesProposal;
use App\Models\User;
use App\Models\Freelancer;
use App\Models\Employer;
use App\Models\ProjectProposal;
use App\Models\ProjectOffer;
use App\Models\UserWallet;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Transaction;
use App\Models\ProjectContract;

class TransactionsController extends Controller
{
    public function transaction_messaage(Request $request) {
        return view('AllScreens.misc.transaction-message');
    }

    public function postback_transaction(Request $request) {
        try {

            $merchant_account = [
                'merchantid' => env('DRAGON_PAY_MERCHANTID'),
                'password'   => env('DRAGON_PAY_MERCHANTKEY')
            ];

            $dragonpay = new Dragonpay($merchant_account);
            $dragonpay->handlePostback(function($data){
                DB::table('user_freelancer')->where('id', 1)->update([
                    'display_name' => 'James Freelancer'
                ]);

                return response('result=ok', 200)
                  ->header('Content-Type', 'text/plain');

            }, $request->all());

        } catch(PaymentException $e){
            echo $e->getMessage();
        } catch(\Exception $e){
            echo $e->getMessage();
        }
    }

    public function view_pay_job(Request $request) {
        if(!$request->type || !$request->id) return view('fail', 'Fail to direct in payment section');
        $user = User::where('id', session()->get('id'))->first();

        //check what type of job
        if($request->type == 'service') {
            $job = ServicesProposal::where('id', $request->id)->with('service', 'freelancer', 'employer')->first();

            $job_data = [
                'title' => $job->service->name,
                'cost' => $job->service->cost,
                'job_type' => $request->type,
                'job_id' => $job->id,
                'from_id' => $job->buyer_id,
                'to_id' => $job->seller_id
            ];
        }

        if($request->type == 'project') {
            $job = ProjectContract::where('id', $request->id)->where('status', 0)->where('is_start_working', 1)->with('project', 'proposal', 'employer', 'freelancer')->firstOrFail();
            $job_data = [
                'title' => $job->project->title,
                'cost' => $job->total_cost,
                'job_type' => $request->type,
                'job_id' => $job->id,
                'from_id' => $job->employer_id,
                'to_id' => $job->freelancer_id,
            ];
        }
        return view('UserAuthScreens.checkout.pay-job', compact('job_data', 'user'));
    }

    public function check_status(Request $request) {
        $freelancers = ProjectProposal::select('freelancer_id', DB::raw('COUNT(freelancer_id) AS occurrences'))
        ->groupBy('freelancer_id')
        ->where('status', 'completed')
        ->orderBy('occurrences', 'DESC')
        ->limit(10)
        ->with('freelancer')
        ->get();
    }

    public function pay_job(Request $request) {
        $request->validate([
            'job_cost' => 'required|numeric',
            'system_deduction' => 'required|numeric',
            'total' => 'required|numeric',
            'employer_id' => 'required|numeric',
            'freelancer_id' => 'required|numeric',
            'payment_method' => 'required',
            'job_type' => 'required|in:project,service'
        ]);

        $services_proposal = null;
        $project_contract = null;

        $system_deduction = $request->job_cost * 0.15;
        $total = 0;

        //check if the employer exist
        $employer = Employer::where('id', $request->employer_id)->with('user')->first();
        if(!$employer) return back()->with('fail', "Employer doesn't exists.");

        //check if the employer exist
        $freelancer = Freelancer::where('id', $request->freelancer_id)->with('user')->first();
        if(!$freelancer) return back()->with('fail', "Freelancer doesn't exists.");

        if($request->job_type == 'service') {
            $services_proposal = ServicesProposal::where('id', $request->job_id)->with('service')->firstOrFail();
            if($services_proposal->status == 'completed') return back()->with('fail', "This Job is already completed.");
        }

        # check if the job type request is project then check if the status is already completed
        if($request->job_type == 'project') {
            $project_contract = ProjectContract::where('id', $request->job_id)->with('project')->firstOrFail();
            if($project_contract->status) return back()->with('fail', "This Job is already completed.");
            $total = $project_contract->total_cost - $system_deduction;
        }

        // check if the employer wallet exist
        $employer_wallet = UserWallet::where('user_id', $employer->user->id)->first();
        if(!$employer_wallet) return back()->with('fail', "The Employer's Wallet doesn't exists. Create Your Wallet First before sending a transaction. Thankyou.");

        $deduct_to_employer = $this->DeductToEmployer($employer_wallet, $employer, $project_contract->total_cost);

        // check if the freelancer has a wallet and if doesn't exist the system will auto generate a wallet for freelancer
        $freelancer_wallet = UserWallet::where('user_id', $freelancer->user->id)->first();

        if(!$freelancer_wallet) {
            $update_wallet = UserWallet::create([
                'user_id' => $freelancer->user_id,
                'amount' =>  $total,
            ]);
        } else {
            $update_wallet = UserWallet::where('user_id', $freelancer_wallet->user_id)->update([
                'amount' => $freelancer_wallet->amount + $total,
            ]);
        }

        // Generate Transaction Code
        $transaction_code = strtoupper(Str::random(8));

        // Create Transaction Data
        $create_transaction = Transaction::create([
            'name_of_transaction' => $request->job_type == 'service' ? 'Pay Service' : 'Pay Project',
            'transaction_code' => $transaction_code,
            'amount' => $total,
            'from_id' => $employer->user_id,
            'to_id' => $freelancer->user_id,
            'payment_method' => $request->payment_method,
            'status' => 'pending'
        ]);

        // // Generate Invoice Code
        // $invoice_code = strtoupper(Str::random(8));

        // // Create Invoice
        // $invoice = Invoice::create([
        //     'invoice_name' => $request->job_type == 'service' ? 'Pay a Service' : 'Pay a Project',
        //     'date_issue' => Carbon::now(),
        //     'due_date' => Carbon::now()->addDays(5),
        //     'invoice_code' => $invoice_code,
        //     'bill_from' => $employer->user_id,
        //     'bill_to' => $freelancer->user_id,
        //     'payment_method' => $request->payment_method,
        //     'invoice_date' => Carbon::now(),
        // ])->id;

        // // Create Invoice Item
        // $create_invoice_item = InvoiceItem::create([
        //     'invoice_id' => $invoice,
        //     'item' => $request->job_type == 'service' ? $services_proposal->service->name : $project->project->title,
        //     'quantity' => 1,
        //     'deduction' => $request->system_deduction,
        //     'amount' => $total
        // ]);

        if(!$create_transaction || !$freelancer_wallet || !$deduct_to_employer['status']) return back()->with('fail', 'Something went wrong. Please Try Again Later');

        if($services_proposal) {
            $services_proposal->status = 'completed';
            $services_proposal->save();
        }

        if($project_contract) {
            if($project_contract->proposal_type == 'offer') {
                ProjectOffer::where('id', $project_contract->proposal_id)->update([
                    'status' => 'completed'
                ]);
            }

            if($project_contract->proposal_type == 'proposal') {
                ProjectProposal::where('id', $project_contract->proposal_id)->update([
                    'status' => 'completed'
                ]);
            }

            # change the status of contract
            $project_contract->job_done = true;
            $project_contract->job_done_date = date('Y-m-d H:i:s');
            $project_contract->status = true;
            $project_contract->save();

            #change the status of specific project
            $project_contract_save = $project_contract->project()->update([
                'status' => 'completed'
            ]);
        }

        return redirect('/transaction-message')->with('success', 'Success Sending Payment');
    }

    private function DeductToEmployer($employer_wallet, $employer, $job_cost) {
        // deduct job cost in employer
        if($employer_wallet->amount >= $job_cost) {
            $update_wallet = UserWallet::where('user_id', $employer->user->id)->update([
                'user_id' => $employer->user->id,
                'amount' =>  $employer_wallet->amount - $job_cost,
            ]);
        } else {
            return back()->with('fail', "The amount in your wallet will not less than the job cost.");
        }

        if($update_wallet) {
            return ['status' => true, 'message' => "The Service Payment has been successfully deducted from the employer"];
        } else {
            return ['status' => false, 'message' => "Oops! The wallet doesn't update. Please Try Again"];
        }
    }

    public function paid_by_wallet_message(Request $request) {
        return view('AllScreens.transaction_messages.success');
    }
}
