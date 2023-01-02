<?php

namespace App\Http\Controllers\Web;

use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Luigel\Paymongo\Facades\Paymongo;
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

use App\Http\Requests\PayJob\PayJobRequest;

class TransactionsController extends Controller
{
    public function transaction_messaage(Request $request) {
        return view('AllScreens.misc.transaction-message');
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

    public function pay_job(PayJobRequest $request) {
        $services_proposal = null;
        $project_contract = null;

        $system_deduction = $request->job_cost * 0.15;
        $total = 0;

        //check if the employer exist
        $employer = Employer::where('id', $request->employer_id)->with('user')->firstOr(function () {
            return back()->with('fail', "Employer doesn't exists.");
        });

        //check if the employer exist
        $freelancer = Freelancer::where('id', $request->freelancer_id)->with('user')->firstOr(function () {
            return back()->with('fail', "Freelancer doesn't exists.");
        });

        # check if the job type request is project then check if the status is already completed
        if($request->job_type == 'project') {
            $project_contract = ProjectContract::where('id', $request->job_id)->with('project')->firstOrFail();
            if($project_contract->status) return back()->with('fail', "This Job is already completed.");
            $total = $project_contract->total_cost - $system_deduction;
        }

        switch ($request->payment_method) {
            case 'pay_using_wallet':

                // check if the employer wallet exist
                $employer_wallet = UserWallet::where('user_id', $employer->user->id)->firstOr(function () {
                    return back()->with('fail', "The Employer's Wallet doesn't exists. Create Your Wallet First before sending a transaction. Thankyou.");
                });

                $freelancer_wallet = UserWallet::where('user_id', $freelancer->user->id)->first();

                $deduct_to_employer = $this->DeductToEmployer($employer_wallet, $employer, $project_contract->total_cost);

                $add_amount_to_freelancer = $this->AddAmountToFreelancer($freelancer, $total, $freelancer_wallet);

                // Generate Transaction Code
                $transaction_code = 'TXN-ID' . '-' . strtoupper(Str::random(16));

                // Create Transaction Data
                $create_transaction = Transaction::create([
                    'name_of_transaction' => $request->job_type == 'service' ? 'Pay Service' : 'Pay Project',
                    'transaction_code' => $transaction_code,
                    'amount' => $total,
                    'from_id' => $employer->user_id,
                    'to_id' => $freelancer->user_id,
                    'payment_method' => $request->payment_method,
                    'status' => 'success'
                ]);

                if(!$create_transaction || !$freelancer_wallet || !$deduct_to_employer['status']) return back()->with('fail', 'Something went wrong. Please Try Again Later');

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

            case 'gcash':

                // Generate Transaction Code
                $transaction_code = 'TXN-ID' . '-' . strtoupper(Str::random(16));

                // Create Transaction Data
                $transaction = Transaction::create([
                    'name_of_transaction' => $request->job_type == 'service' ? 'Pay Service' : 'Pay Project',
                    'transaction_code' => $transaction_code,
                    'amount' => $total,
                    'from_id' => $employer->user_id,
                    'to_id' => $freelancer->user_id,
                    'payment_method' => $request->payment_method,
                    'status' => 'initial'
                ]);

                $payload = [
                    'type' => $request->payment_method,
                    'amount' => $total,
                    'currency' => 'PHP',
                    'redirect' => [
                        'success' => route('transaction.success', $transaction->transaction_code),
                        'failed' =>  route('transaction.failed', $transaction->transaction_code),
                    ]
                ];

                $source = Paymongo::source()->create($payload);

                $transaction->update([
                    'src_id' => $source->id,
                    'status' => $source->status,
                ]);

                return redirect($source->redirect['checkout_url']);

            case 'paymaya':
                # code...
                break;

            case 'card':
                # code...
                break;
        }
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

    public function AddAmountToFreelancer($freelancer, $total, $freelancer_wallet){
        // check if the freelancer has a wallet and if doesn't exist the system will auto generate a wallet for freelancer
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

        if($update_wallet) {
            return ['status' => true, 'message' => "The Service Payment has been successfully add to the freelancer"];
        } else {
            return ['status' => false, 'message' => "Oops! The wallet doesn't update. Please Try Again"];
        }
    }

    public function success(Request $request) {
        $transaction = Transaction::where('transaction_code', $request->txn_code)->with('user_from', 'user_to')->first();

        $source = Paymongo::source()->find($transaction->src_id);

        if ($transaction->status == 'pending') {
            $transaction->update([
                'source_callback_response' => $source->getAttributes(),
                'status' => $source->status,
            ]);
        }

        switch ($source->status) {
            case 'chargeable':
                $payment = Paymongo::payment()->create([
                    'amount' => $transaction->amount,
                    'description' => $transaction->readable_type . ' Payment for Transaction Code: ' . $transaction->transaction_code,
                    'currency' => 'PHP',
                    'statement_descriptor' => $transaction->user_from->firstname . ' ' . $transaction->user_to->lastname,
                    'source' => [
                        'id' => $source->id,
                        'type' => 'source',
                    ]
                ]);

                $transaction->update([
                    'payment_response' => $payment->getAttributes(),
                    'pay_id' => $payment->id,
                    'status' => $payment->status
                ]);
                break;

            case 'paid':
                if (!$transaction->pay_id) {
                    foreach (Paymongo::payment()->all() as $payment) {
                        if ($payment->source['id'] == $transaction->src_id) {
                            $transaction->update([
                                'pay_id' => $payment->id,
                                'status' => $payment->status
                            ]);
                            break;
                        }
                    }
                } else {
                    $payment = Paymongo::payment()->find($transaction->pay_id);
                    $transaction->update([
                        'pay_id' => $payment->id,
                        'status' => $payment->status
                    ]);
                }
                break;
        }
        
        return view('AllScreens.misc.transaction-messages.success');
    }

    public function failed(Request $request) {
        $transaction = Transaction::where('transaction_code', $request->txn_code)->with('user_from', 'user_to')->first();
        $source = Paymongo::source()->find($transaction->src_id);

        if ($transaction->status == 'pending') {
            $transaction->update([
                'source_callback_response' => $source->getAttributes(),
                'status' => 'fail',
            ]);
        }
        
        return view('AllScreens.misc.transaction-messages.failed');
    }
}
