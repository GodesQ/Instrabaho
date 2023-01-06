<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\UserWallet;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\EWalletPayment;
use App\Models\CardPayment;
use App\Models\ProjectPayment;

use Luigel\Paymongo\Facades\Paymongo;
use Illuminate\Support\Str;

class UserFundsController extends Controller
{
    public function user_funds() {
        $user = User::where('id', session()->get('id'))->with('wallet')->first();
        // dd(session()->get('id'));
        $transactions = Transaction::where('from_id', session()->get('id'))->orWhere('to_id', session()->get('id'))->cursorPaginate(10);
        // dd($transactions);
        return view('UserAuthScreens.funds.funds', compact('user', 'transactions'));
    }

    public function deposit(Request $request) {
        $request->validate([
            'user_id' => 'required|exists:user,id',
            'amount' => 'required|numeric',
            'payment_method' => 'required|in:gcash,grab_pay,card,paymaya'
        ]);

        $amount = $request->amount;
        $user = User::where('id', $request->user_id)->first();

        switch ($request->payment_method) {
            case 'gcash':
            case 'grab_pay':

                // Generate Transaction Code
                $transaction_code = 'TXN-ID' . '-' . strtoupper(Str::random(16));

                $transaction = Transaction::create([
                    'name_of_transaction' => 'Deposit',
                    'transaction_type' => 'deposit',
                    'transaction_code' => $transaction_code,
                    'amount' => $amount,
                    'sub_amount' => $amount,
                    'from_id' => $user->id,
                    'to_id' => 0,
                    'payment_method' => $request->payment_method,
                    'status' => 'initial'
                ]);

                // Create E-Wallet Payment Data
                $eWalletPayment = EWalletPayment::create([
                    'user_id' => $user->id,
                    'transaction_code' => $transaction->transaction_code,
                    'amount' => $amount,
                    'sub_amount' => $amount,
                    'type' => $request->payment_method,
                    'status' => 'initial',
                ]);

                $payload = [
                    'type' => $request->payment_method,
                    'amount' => $amount,
                    'currency' => 'PHP',
                    'redirect' => [
                        'success' => route('transaction.success', ['txn_code' => $transaction->transaction_code, 'type' => 'deposit']),
                        'failed' =>  route('transaction.failed', ['txn_code' => $transaction->transaction_code, 'type' => 'deposit']),
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

                return redirect($source->redirect['checkout_url']);

            case 'card':
                // Generate Transaction Code
                $transaction_code = 'TXN-ID' . '-' . strtoupper(Str::random(16));

                // Create Transaction Data
                $transaction = Transaction::create([
                    'name_of_transaction' => 'Deposit',
                    'transaction_type' => 'deposit',
                    'transaction_code' => $transaction_code,
                    'amount' => $amount,
                    'sub_amount' => $amount,
                    'from_id' => $user->id,
                    'to_id' =>0,
                    'payment_method' => $request->payment_method,
                    'status' => 'initial'
                ]);


                $cardPayment = CardPayment::create([
                    'user_id' => $user->id,
                    'amount' => $amount,
                    'sub_amount' => $amount,
                    'transaction_code' => $transaction->transaction_code
                ]);

                $payload = [
                    'amount' => $amount,
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
                        'name' => $user->firstname . ' ' . $user->lastname,
                        'email' => $user->email,
                    ]
                ]);

                $cardPayment->update([
                    'pm_id' => $paymentMethod->id,
                    'payment_method_response' => $paymentMethod->getAttributes(),
                ]);

                return $this->attachPaymentToIntent($paymentIntent, $paymentMethod, $transaction, $cardPayment);
        }
    }

    private function attachPaymentToIntent($paymentIntent, $paymentMethod, $transaction, $cardPayment) {
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
                return back()->with('success', 'Deposit Successfully.');
            case 'awaiting_payment_method':
                return dd([
                    'CHECK LAST PAYMENT ERROR',
                    $paymentIntent,
                ]);
            case 'processing':
                # delay 2 seconds
                sleep(2);

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
        }
    }


}
