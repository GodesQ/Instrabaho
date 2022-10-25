<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\UserWallet;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Invoice;
use App\Models\InvoiceItem;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Crazymeeks\Foundation\PaymentGateway\Dragonpay;
use Crazymeeks\Foundation\PaymentGateway\Dragonpay\Token;
use Ixudra\Curl\Facades\Curl;

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
        $user_wallet = UserWallet::where('user_id', session()->get('id'))->first();

        if($request->action == 'Create') {
            $request->validate([
                'amount' => 'required|numeric',
                'payment_method' => 'required'
            ]);

            // Generate Transaction Code
            $transaction_code = strtoupper(Str::random(8));

            // Create Transaction
            $create_transaction = Transaction::create([
                'name_of_transaction' => 'Deposit',
                'transaction_code' => $transaction_code,
                'amount' => $request->amount,
                'from_id' => 0,
                'to_id' => session()->get('id'),
                'payment_method' => $request->payment_method,
                'status' => 'success'
            ]);

            // Generate Invoice Code
            $invoice_code = strtoupper(Str::random(8));

            // Create Invoice
            $invoice = Invoice::create([
                'invoice_name' => 'Deposit',
                'date_issue' => Carbon::now(),
                'due_date' => Carbon::now()->addDays(5),
                'invoice_code' => $invoice_code,
                'bill_from' => 0,
                'bill_to' => session()->get('id'),
                'payment_method' => $request->payment_method,
                'invoice_date' => Carbon::now(),
            ])->id;
            
            // Create Invoice Item
            $create_invoice_item = InvoiceItem::create([
                'invoice_id' => $invoice,
                'item' => 'Deposit Amount in Wallet',
                'quantity' => 1,
                'amount' => $request->amount
            ]);
            
            if(!$user_wallet) {
                $create_wallet = UserWallet::create([
                    'user_id' => session()->get('id'),
                    'amount' =>  $request->amount,
                ]);
            } else {
                $create_wallet = UserWallet::where('user_id', $user_wallet->user_id)->update([
                    'amount' => $user_wallet->amount + $request->amount,
                ]);
            }

            $parameters = [
                'txnid' => $transaction_code, 
                'amount' => $request->amount, 
                'ccy' => 'PHP',
                'description' => 'Deposit Money', 
                'email' => session()->get('email'),
                'param1' => session()->get('id'), 
            ];
    
            $merchant_account = [
                'merchantid' => env('DRAGON_PAY_MERCHANTID'),
                'password'   => env('DRAGON_PAY_MERCHANTKEY')
            ];
            
            // Initialize Dragonpay
            $dragonpay = new Dragonpay($merchant_account);
            $dragonpay->setParameters($parameters)->away();
            // return back()->with('success', 'Add Amount Successfully');
        }
        
        $request->validate([
            'payment_method' => 'required'
        ]);

        if(!$user_wallet) {
            $create_wallet = UserWallet::create([
                'user_id' => session()->get('id'),
                'amount' => $user_wallet + 0,
            ]);

            User::where('id', session()->get('id'))->update([
                'prefer_payment_method' => $request->payment_method
            ]);
        }

        return back()->with('success', 'Add Amount Successfully');
    }
}