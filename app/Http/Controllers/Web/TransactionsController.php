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

    public function card_payment_success(Request $request) {
        $transaction = Transaction::where('transaction_code', $request->txn_code)->first();
        return view('UserAuthScreens.transactions.card-payment.success');
    }

    public function card_payment_failed(Request $request) {
        $transaction = Transaction::where('transaction_code', $request->txn_code)->first();
        return view('UserAuthScreens.transactions.card-payment.failed');
    }

    public function ewallet_payment_success(Request $request) {
        $transaction = Transaction::where('transaction_code', $request->txn_code)->with('user_from', 'user_to')->first();
        $eWalletPayment = EWalletPayment::where('transaction_id', $request->txn_code)->first();
        return view('UserAuthScreens.transactions.e-wallet-payment.success');
    }

    public function ewallet_payment_failed(Request $request) {
        $transaction = Transaction::where('transaction_code', $request->txn_code)->first();
        return view('UserAuthScreens.transactions.e-wallet-payment.failed');
    }
}
