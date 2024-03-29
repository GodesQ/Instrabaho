<?php

namespace App\Http\Controllers\Web;

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

use App\Actions\PayProject\PaidByEWallet;

use App\Http\Requests\PayJob\PayJobRequest;

class ProjectPayJobController extends Controller
{
    public function view_pay_job(Request $request) {
        if(!$request->type || !$request->id) return view('fail', 'Fail to direct in payment section');
        $user = User::where('id', session()->get('id'))->first();

        //check what type of job
        if($request->type == 'service') {
            $job = ServicesProposal::where('id', $request->id)->with('service', 'freelancer', 'employer')->first();

            $job_data = [
                'title' => $job->service->name,
                'cost' => $job->service->cost,
                'cost_type' => 'Fixed',
                'job_type' => $request->type,
                'job_id' => $job->id,
                'from_id' => $job->buyer_id,
                'to_id' => $job->seller_id
            ];
        }

        if($request->type == 'project') {
           $job = ProjectContract::where('id', $request->id)->where('status', 0)->where('is_start_working', 1)->with('project', 'proposal', 'employer', 'freelancer', 'tracker')->firstOrFail();
            $job_data = [
                'title' => $job->project->title,
                'cost' => $job->cost_type == 'Hourly' ? $job->tracker->total_hours_cost : $job->cost,
                'cost_type' => $job->cost_type,
                'job_type' => $request->type,
                'job_id' => $job->id,
                'from_id' => $job->employer_id,
                'to_id' => $job->freelancer_id,
            ];
        }
        // dd($job_data);

        return view('UserAuthScreens.checkout.pay-job', compact('job_data', 'user'));
    }

    public function pay_job(PayJobRequest $request) {
        $services_proposal = null;
        $project_contract = null;

        $system_deduction = $request->job_cost * 0.15;
        $total = 0;

        $employer_total_cost = 0;

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

            if($project_contract->cost_type == "Hourly") {
                $total = $project_contract->tracker->total_hours_cost - $system_deduction;
                $employer_total_cost = $project_contract->tracker->total_hours_cost + 50;
            } else {
                $employer_total_cost =  $project_contract->total_cost;
            }
        }

        switch ($request->payment_method) {
            case 'pay_using_wallet':

                // check if the employer wallet exist
                $employer_wallet = UserWallet::where('user_id', $employer->user->id)->firstOr(function () {
                    return back()->with('fail', "The Employer's Wallet doesn't exists. Create Your Wallet First before sending a transaction. Thankyou.");
                });

                $freelancer_wallet = UserWallet::where('user_id', $freelancer->user->id)->first();

                $deduct_to_employer = $this->DeductToEmployer($employer_wallet, $employer, $employer_total_cost);

                $add_amount_to_freelancer = $this->AddAmountToFreelancer($freelancer, $total, $freelancer_wallet);

                // Generate Transaction Code
                $transaction_code = 'TXN-ID' . '-' . strtoupper(Str::random(16));

                // Create Transaction Data
                $create_transaction = Transaction::create([
                    'name_of_transaction' => $request->job_type == 'service' ? 'Pay Service' : 'Pay Project',
                    'transaction_type' => 'pay_project',
                    'transaction_code' => $transaction_code,
                    'amount' => $employer_total_cost,
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
                        'employer_total' => $employer_total_cost,
                        'freelancer_total' => $total,
                    ]);
                }

                return redirect()->route('transaction.success', ['txn_code' => $transaction->transaction_code])->with('success', 'Success Sending Payment');

            case 'gcash':
            case 'grab_pay':
                $paid_by_ewallet = new PaidByEWallet;
                return $paid_by_ewallet->action($project_contract, $request, $employer_total_cost, $total, $employer, $freelancer);
            case 'paymaya':
                # code...
                break;
            case 'card':
                // Generate Transaction Code
                $transaction_code = 'TXN-ID' . '-' . strtoupper(Str::random(16));

                // Create Transaction Data
                $transaction = Transaction::create([
                    'name_of_transaction' => $request->job_type == 'service' ? 'Pay Service' : 'Pay Project',
                    'transaction_type' => 'pay_project',
                    'transaction_code' => $transaction_code,
                    'amount' => $employer_total_cost,
                    'sub_amount' => $project_contract->total_cost,
                    'from_id' => $employer->user_id,
                    'to_id' => $freelancer->user_id,
                    'payment_method' => $request->payment_method,
                    'status' => 'initial'
                ]);


                // Create Project Payment Data
                $project_payment = ProjectPayment::create([
                    'user_id' => $employer->user_id,
                    'contract_id' => $project_contract->id,
                    'transaction_code' => $transaction->transaction_code,
                    'employer_total' => $employer_total_cost,
                    'freelancer_total' => $total,
                ]);

                $cardPayment = CardPayment::create([
                    'user_id' => $employer->user_id,
                    'amount' => $employer_total_cost,
                    'sub_amount' => $project_contract->total_cost,
                    'transaction_code' => $transaction->transaction_code
                ]);

                $payload = [
                    'amount' => $employer_total_cost,
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

    public function AddAmountToFreelancer($freelancer, $total, $freelancer_wallet) {

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
            'status' => $paymentIntent->status,
        ]);

        switch ($paymentIntent->status) {
            case 'awaiting_next_action':
                return redirect()->route('card-payment.security_check', $transaction->id);

            case 'succeeded':

            case 'awaiting_payment_method':
                return dd([
                    'CHECK LAST PAYMENT ERROR',
                    $paymentIntent,
                ]);
            case 'processing':
                # delay 2 seconds
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
}
