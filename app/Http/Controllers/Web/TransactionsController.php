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
use App\Models\UserWallet;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Transaction;

class TransactionsController extends Controller
{
    public function transaction_messaage(Request $request) {
        return view('misc.transaction-message');
    }

    public function postback_transaction(Request $request) {
        try {
            $merchant_account = [
                'merchantid' => env('DRAGON_PAY_MERCHANTID'),
                'password'   => env('DRAGON_PAY_MERCHANTKEY')
            ];

            $_POST = $request;

            $dragonpay = new Dragonpay($merchant_account);
            $dragonpay->handlePostback(function($data){
                DB::table('user_freelancer')->update([
                    'display_name' => 'James Freelancer'
                ]);
            }, $request->all());
            echo 'result=OK';
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
            $job = ProjectProposal::where('id', $request->id)->with('project', 'freelancer', 'employer')->first();
            $job_data = [
                'title' => $job->project->title,
                'cost' => $job->project->cost,
                'job_type' => $request->type,
                'job_id' => $job->id,
                'from_id' => $job->employer_id,
                'to_id' => $job->freelancer_id
            ];
        }
        return view('checkout.pay-job', compact('job_data', 'user'));
    }

    public function check_status(Request $request) {
        $freelancers = ServicesProposal::select('seller_id', DB::raw('COUNT(seller_id) AS occurrences'))
        ->groupBy('seller_id')
        ->where('status', 'completed')
        ->orderBy('occurrences', 'DESC')
        ->limit(10)
        ->get();
    }

    public function pay_job(Request $request) {
        $request->validate([
            'job_cost' => 'required|numeric',
            'system_deduction' => 'required|numeric',
            'total' => 'required|numeric',
            'employer_id' => 'required|numeric',
            'freelancer_id' => 'required|numeric',
            'payment_method' => 'required'
        ]);

        $services_proposal = null;
        $project_proposal = null;

        //check if the employer exist
        $employer = Employer::where('id', $request->employer_id)->with('user')->first();
        if(!$employer) return back()->with('fail', "Employer doesn't exists.");

        //check if the employer exist
        $freelancer = Freelancer::where('id', $request->freelancer_id)->with('user')->first();
        if(!$freelancer) return back()->with('fail', "Freelancer doesn't exists.");

        if($request->job_type == 'service') {
            $services_proposal = ServicesProposal::where('id', $request->job_id)->with('service')->first();
            if(!$services_proposal) return back()->with('fail', "Service doesn't exists");
        }

        if($request->job_type == 'project') {
            $project_proposal = ProjectProposal::where('id', $request->job_id)->with('project')->first();
            if(!$project_proposal) return back()->with('fail', "Project doesn't exists");
        }

        // check if the employer wallet exist
        $employer_wallet = UserWallet::where('user_id', $employer->user->id)->first();
        if(!$employer_wallet) return back()->with('fail', "The Employer's Wallet doesn't exists. Create Your Wallet First before sending a transaction. Thankyou.");

        // Generate Transaction Code
        $transaction_code = strtoupper(Str::random(8));

        // Create Transaction
        $create_transaction = Transaction::create([
            'name_of_transaction' => $request->job_type == 'service' ? 'Pay Service' : 'Pay Project',
            'transaction_code' => $transaction_code,
            'amount' => $request->total,
            'from_id' => $employer->user_id,
            'to_id' => $freelancer->user_id,
            'payment_method' => $request->payment_method,
            'status' => 'success'
        ]);

        // Generate Invoice Code
        $invoice_code = strtoupper(Str::random(8));

        // Create Invoice
        $invoice = Invoice::create([
            'invoice_name' => $request->job_type == 'service' ? 'Pay a Service' : 'Pay a Project',
            'date_issue' => Carbon::now(),
            'due_date' => Carbon::now()->addDays(5),
            'invoice_code' => $invoice_code,
            'bill_from' => $employer->user_id,
            'bill_to' => $freelancer->user_id,
            'payment_method' => $request->payment_method,
            'invoice_date' => Carbon::now(),
        ])->id;
        
        // Create Invoice Item
        $create_invoice_item = InvoiceItem::create([
            'invoice_id' => $invoice,
            'item' => $request->job_type == 'service' ? $services_proposal->service->name : $project_proposal->project->title,
            'quantity' => 1,
            'deduction' => $request->system_deduction,
            'amount' => $request->total
        ]);

        // check if the freelancer has a wallet and if doesn't exist the system will auto generate a wallet for freelancer
        $freelancer_wallet = UserWallet::where('user_id', $freelancer->user_id)->first();

        if(!$freelancer_wallet) {
            $create_wallet = UserWallet::create([
                'user_id' => $freelancer->user_id,
                'amount' =>  $request->total,
            ]);
        } else {
            $create_wallet = UserWallet::where('user_id', $freelancer_wallet->user_id)->update([
                'amount' => $freelancer_wallet->amount + $request->total,
            ]);
        }

        $deduct_to_employer = $this->DeductToEmployer($employer_wallet, $employer, $request->job_cost);

        if(!$create_transaction || !$invoice || !$create_invoice_item || !$create_wallet || !$deduct_to_employer['status']) return back()->with('fail', 'Something went wrong. Please Try Again Later');

        if($services_proposal) {
            $services_proposal->status = 'completed';
            $services_proposal->save();
        } else {
            $project_proposal->status = 'completed';
            $project_proposal->save();
        }
        
        return redirect('/transaction-message')->with('success', 'Success Sending Payment');
    }

    private function PayJoBUsingWallet() {
        
    }

    private function DeductToEmployer($employer_wallet, $employer, $job_cost) {
        // deduct job cost in employer
        if($employer_wallet->amount >= $job_cost) {
            $update_wallet = UserWallet::where('user_id', $employer->user->id)->update([
                'user_id' => $employer->user->id,
                'amount' =>  $employer_wallet->amount - $job_cost,
            ]);
        } else {
            return back()->with('fail', "The amount of your wallet will not less than to the job cost.");
        }

        if($update_wallet) {
            return ['status' => true, 'message' => "The Service Payment has been successfully deduct to employer"];
        } else {
            return ['status' => false, 'message' => "Oops! The wallet doesn't update. Please Try Again"];
        }
    }

    public function paid_by_wallet_message(Request $request) {
        return view('transaction_messages.success');
    }
}