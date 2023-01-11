<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
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

class CardPaymentCallBackController extends Controller
{
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

        if($paymentIntent->status == 'succeeded') {
            if($transaction->transaction_type == 'pay_project') {
                $project_payment = ProjectPayment::where('transaction_code', $transaction->transaction_code)->first();

                if($project_payment) {
                    $project_contract = ProjectContract::where('id', $project_payment->contract_id)->first();

                    $user_wallet = UserWallet::where('user_id', $transaction->to_id)->first();

                    if($user_wallet) {
                        $user_wallet->update([
                            'amount' => $user_wallet->amount += $project_payment->freelancer_total,
                        ]);
                    } else {
                        $user_wallet = UserWallet::create([
                            'user_id' => $transaction->from_id,
                            'amount' => $project_payment->freelancer_total
                        ]);
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
                }
                return redirect()->route('employer.projects.completed')->with('success', 'Payment Successfully Completed.');
            }

            if($transaction->transaction_type == 'deposit') {
                $user_wallet = UserWallet::where('user_id', $transaction->from_id)->first();
                if($user_wallet) {
                    $user_wallet->update([
                        'amount' => $user_wallet->amount += $transaction->amount,
                    ]);
                } else {
                    $user_wallet = User::create([
                        'user_id' => $transaction->from_id,
                        'amount' => $transaction->amount
                    ]);
                }
                return redirect()->route('user_funds')->with('success', 'Payment Successfully Completed.');
            }
        }
    }

    public function security_check(Request $request) {
        $transaction = Transaction::where('id', $request->id)->first();
        $cardPayment = CardPayment::where('transaction_code', $transaction->transaction_code)->first();

        if ($transaction->status != 'awaiting_next_action')  return back()->withErrors('Fail! The Status is not awaiting next action');
        return view('UserAuthScreens.checkout.security-check', compact('transaction', 'cardPayment'));
    }
}
