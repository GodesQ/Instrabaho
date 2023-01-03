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
use App\Models\EWalletPayment;
use App\Models\CardPayment;
use App\Models\ProjectPayment;

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
                    'sub_amount' => $project_contract->total_cost,
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

                    // Create Project Payment Data
                    $project_payment = ProjectPayment::create([
                        'user_id' => $employer->user_id,
                        'contract_id' => $project_contract->id,
                        'transaction_code' => $create_transaction->transaction_code,
                        'sub_total' => $project_contract->total_cost,
                        'total' => $total,
                        'status' => 'paid',
                    ]);

                }
                return redirect()->route('transaction.success', ['txn_code' => $transaction->transaction_code])->with('success', 'Success Sending Payment');

            case 'gcash':
            case 'grab_pay':

                // Generate Transaction Code
                $transaction_code = 'TXN-ID' . '-' . strtoupper(Str::random(16));

                if($project_contract) {

                    // Create Transaction Data
                    $transaction = Transaction::create([
                        'name_of_transaction' => $request->job_type == 'service' ? 'Pay Service' : 'Pay Project',
                        'transaction_code' => $transaction_code,
                        'amount' => $total,
                        'sub_amount' => $project_contract->total_cost,
                        'from_id' => $employer->user_id,
                        'to_id' => $freelancer->user_id,
                        'payment_method' => $request->payment_method,
                        'status' => 'initial'
                    ]);

                    // Create E-Wallet Payment Data
                    $eWalletPayment = EWalletPayment::create([
                        'user_id' => $employer->user_id,
                        'transaction_id' => $transaction->transaction_code,
                        'amount' => $total,
                        'sub_amount' => $project_contract->total_cost,
                        'type' => $request->payment_method,
                        'status' => 'initial',
                    ]);

                    // Create Project Payment Data
                    $project_payment = ProjectPayment::create([
                        'user_id' => $employer->user_id,
                        'contract_id' => $project_contract->id,
                        'transaction_code' => $transaction->transaction_code,
                        'sub_total' => $project_contract->total_cost,
                        'total' => $total,
                        'status' => 'initial',
                    ]);
                }

                $payload = [
                    'type' => $request->payment_method,
                    'amount' => $project_contract->total_cost,
                    'currency' => 'PHP',
                    'redirect' => [
                        'success' => route('transaction.success', ['txn_code' => $transaction->transaction_code, 'type' => $request->job_type]),
                        'failed' =>  route('transaction.failed', ['txn_code' => $transaction->transaction_code, 'type' => $request->job_type]),
                    ]
                ];

                $eWalletPayment->update([
                    'payload' => $payload
                ]);

                $source = Paymongo::source()->create($payload);

                $eWalletPayment->update([
                    'src_id' => $source->id,
                    'source_response' => $source->getAttributes(),
                    'status' => $source->status,
                ]);

                $transaction->update([
                    'src_id' => $source->id,
                    'status' => $source->status,
                ]);

                $project_payment->update([
                    'status' => $source->status
                ]);

                return redirect($source->redirect['checkout_url']);

            case 'paymaya':
                # code...
                break;

            case 'card':

                #
                // Generate Transaction Code
                $transaction_code = 'TXN-ID' . '-' . strtoupper(Str::random(16));

                // Create Transaction Data
                $transaction = Transaction::create([
                    'name_of_transaction' => $request->job_type == 'service' ? 'Pay Service' : 'Pay Project',
                    'transaction_code' => $transaction_code,
                    'amount' => $total,
                    'sub_amount' => $project_contract->total_cost,
                    'from_id' => $employer->user_id,
                    'to_id' => $freelancer->user_id,
                    'payment_method' => $request->payment_method,
                    'status' => 'initial'
                ]);

                $cardPayment = CardPayment::create([
                    'user_id' => $employer->user_id,
                    'transaction_code' => $transaction->transaction_code
                ]);

                $payload = [
                    'amount' => $project_contract->total_cost,
                    'payment_method_allowed' => [
                        'card'
                    ],
                    'payment_method_options' => [
                        'card' => [
                            'request_three_d_secure' => 'automatic'
                        ]
                    ],
                    'description' => 'Card Payment for Transaction Code: ' . $transaction->transaction_code,
                    'statement_descriptor' => 'INSTRABAHO',
                    'currency' => 'PHP',
                ];

                $cardPayment->update([
                    'payload' => $payload
                ]);

                $paymentIntent = Paymongo::paymentIntent()->create($payload);

                $cardPayment->update([
                    'pi_id' => $paymentIntent->id,
                    'payment_intent_response' => $paymentIntent->getAttributes(),
                    'status' => $paymentIntent->status,
                ]);

                $transaction->update([
                    'pi_id' => $paymentIntent->id,
                    'status' => $paymentIntent->status,
                ]);

                $paymentMethod = Paymongo::paymentMethod()->create([
                    'type' => 'card',
                    'details' => [
                        'card_number' => $request->card_number,
                        'exp_month' => (int) $request->expiry_month,
                        'exp_year' => (int) $request->expiry_year,
                        'cvc' => $request->cvc,
                    ],
                    'billing' => [
                        'name' => $employer->user->firstname . ' ' . $employer->user->lastname,
                        'email' => $employer->user->email,
                    ]
                ]);

                $cardPayment->update([
                    'pm_id' => $paymentMethod->id,
                    'payment_method_response' => $paymentMethod->getAttributes(),
                ]);

                $transaction->update([
                    'pm_id' => $paymentMethod->id,
                ]);

                return $this->attachPaymentToIntent($paymentIntent, $paymentMethod, $transaction, $cardPayment);
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

    public function card_update(Request $request) {
        $transaction = Transaction::where('id', $request->id)->first();
        $cardPayment = CardPayment::where('transaction_code', $transaction->transaction_code)->first();

        $paymentIntent =  Paymongo::paymentIntent()->find($cardPayment->pi_id);

        if ($paymentIntent->status == 'awaiting_next_action') {
            return redirect()->route('card-payment.security_check', $transaction->id);
        }

        $transaction->update([
            'status' => $paymentIntent->status,
        ]);

        $cardPayment->update([
            'status' => $paymentIntent->status,
            're_query_response' => $paymentIntent->getAttributes(),
        ]);

        $project_payment = ProjectPayment::where('transaction_code', $transaction->transaction_code)->first();

        if($project_payment) {
            $project_contract = ProjectContract::where('id', $project_payment->contract_id)->first();

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
        }

        return redirect()->route('employer.projects.completed');
        // return redirect()->route('transaction.success', ['txn_code' => $transaction->transaction_code, 'type' => 'project']);
    }

    private function attachPaymentToIntent($paymentIntent, $paymentMethod, $transaction, $cardPayment)
    {
        try {
            $paymentIntent = $paymentIntent->attach($paymentMethod->id);
        } catch (\Luigel\Paymongo\Exceptions\BadRequestException $e) {
            $exception = json_decode($e->getMessage(),  true);
            return redirect()->back()->with('error', $exception['errors'][0]['detail']);
        }

        $cardPayment->update([
            'payment_attach_response' => $paymentIntent->getAttributes(),
            'status' => $paymentIntent->status,
        ]);

        $transaction->update([
            'payment_attach_response' => $paymentIntent->getAttributes(),
            'status' => $paymentIntent->status,
        ]);

        switch ($paymentIntent->status) {
            case 'awaiting_next_action':
                return redirect()->route('card-payment.security_check', $transaction->id);

            case 'succeeded':

                // return redirect()->route('transaction.success', ['txn_code' => $transaction->transaction_code, 'type' => 'project']);

            case 'awaiting_payment_method':
                return dd([
                    'CHECK LAST PAYMENT ERROR',
                    $paymentIntent,
                ]);
            case 'processing':
                sleep(2);

                $paymentIntent =  Paymongo::paymentIntent()->find($transaction->pi_id);

                if ($paymentIntent->status == 'awaiting_next_action') {
                    return redirect()->route('card-payment.security_check', $transaction);
                }

                $transaction->update([
                    'status' => $paymentIntent->status,
                ]);

                $cardPayment->update([
                    'status' => $paymentIntent->status,
                    're_query_response' => $paymentIntent->getAttributes(),
                ]);
        }
    }

    public function security_check(Request $request) {
        $transaction = Transaction::where('id', $request->id)->first();
        $cardPayment = CardPayment::where('transaction_code', $transaction->transaction_code)->first();
        if ($transaction->status != 'awaiting_next_action') {
            dd($transaction);
        }
        return view('UserAuthScreens.checkout.security-check', compact('transaction', 'cardPayment'));
    }
}
