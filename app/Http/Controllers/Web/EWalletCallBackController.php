<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Luigel\Paymongo\Facades\Paymongo;

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



class EWalletCallBackController extends Controller
{
    public function success(Request $request) {

        $transaction = Transaction::where('transaction_code', $request->txn_code)->with('user_from', 'user_to')->first();
        $eWalletPayment = EWalletPayment::where('transaction_code', $request->txn_code)->first();

        $source = Paymongo::source()->find($transaction->src_id);


        if ($transaction->status == 'pending' && $eWalletPayment->status == 'pending') {
            $eWalletPayment->update([
                'source_callback_response' => $source->getAttributes(),
                'status' => $source->status,
            ]);
        }

        if($request->type == 'deposit' && $transaction->transaction_type == 'deposit') {
            $user_wallet = UserWallet::where('user_id', $transaction->from_id)->first();
            if($user_wallet) {
                $user_wallet->update([
                    'amount' => $user_wallet->amount += $transaction->amount,
                ]);
            } else {
                $user_wallet = UserWallet::create([
                    'user_id' => $transaction->from_id,
                    'amount' => $transaction->amount
                ]);
            }
        }

        if($request->type == 'project' && $transaction->transaction_type == 'pay_project') {
            $project_payment = ProjectPayment::where('transaction_code', $request->txn_code)->first();
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

        switch ($source->status) {
            case 'chargeable':
                $payment = Paymongo::payment()->create([
                    'amount' => $transaction->sub_amount,
                    'description' => 'Payment for Transaction Code: ' . $transaction->transaction_code,
                    'currency' => 'PHP',
                    'statement_descriptor' => $transaction->user_from->firstname . ' ' . $transaction->user_from->lastname,
                    'source' => [
                        'id' => $source->id,
                        'type' => 'source',
                    ]
                ]);

                $transaction->update([
                    'pay_id' => $payment->id,
                    'status' => $payment->status
                ]);

                $eWalletPayment->update([
                    'payment_response' => $payment->getAttributes(),
                    'pay_id' => $payment->id,
                    'status' => $payment->status
                ]);

                break;

            case 'paid':
                if ($transaction->pay_id) {
                    $payment = Paymongo::payment()->find($transaction->pay_id);
                    $transaction->update([
                        'pay_id' => $payment->id,
                        'status' => $payment->status
                    ]);
                    $eWalletPayment->update([
                        'payment_response' => $payment->getAttributes(),
                        'pay_id' => $payment->id,
                        'status' => $payment->status
                    ]);

                } else {
                    foreach (Paymongo::payment()->all() as $payment) {
                        if ($payment->source['id'] == $transaction->src_id) {
                            $transaction->update([
                                'pay_id' => $payment->id,
                                'status' => $payment->status
                            ]);

                            $eWalletPayment->update([
                                'payment_response' => $payment->getAttributes(),
                                'pay_id' => $payment->id,
                                'status' => $payment->status
                            ]);
                            break;
                        }
                    }
                }

                break;
        }
        return view('AllScreens.misc.transaction-messages.success');
    }

    public function failed(Request $request) {
        $transaction = Transaction::where('transaction_code', $request->txn_code)->with('user_from', 'user_to')->first();
        $eWalletPayment = EWalletPayment::where('transaction_code', $request->txn_code)->first();
        $source = Paymongo::source()->find($transaction->src_id);

        if ($transaction->status == 'pending') {
            $transaction->update([
                'status' => 'failed',
            ]);

            $eWalletPayment->update([
                'source_callback_response' => $source->getAttributes(),
                'status' => 'failed',
            ]);
        }

        return view('AllScreens.misc.transaction-messages.failed');
    }
}
