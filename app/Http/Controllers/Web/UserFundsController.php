<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\UserWallet;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\EWalletPayment;
use App\Models\CardPayment;
use App\Models\ProjectPayment;
use App\Models\GcashWithdrawal;
use App\Models\CardWithdrawal;
use App\Models\Withdrawal;

use App\Http\Requests\Withdrawal\PostWithdrawal;

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
}
