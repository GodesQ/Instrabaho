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
use Yajra\DataTables\Facades\DataTables;


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
        $transaction = Transaction::where('transaction_code', $request->txn_code)
                        ->where('status', 'paid')
                        ->orWhere('status', 'chargeable')
                        ->with('user_from', 'user_to')->firstOrFail();

        $eWalletPayment = EWalletPayment::where('transaction_code', $request->txn_code)->first();

        return view('UserAuthScreens.transactions.e-wallet-payment.success', compact('transaction', 'eWalletPayment'));
    }

    public function ewallet_payment_failed(Request $request) {
        $transaction = Transaction::where('transaction_code', $request->txn_code)->first();
        return view('UserAuthScreens.transactions.e-wallet-payment.failed');
    }

    public function index() {
        return view('AdminScreens.transactions.transactions');
    }

    public function data_table(Request $request) {
        abort_if(!$request->ajax(), 404);
        $data = Transaction::select('*')->with('user_from');
        return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('from', function($row) {
                    return $row->user_from->firstname . ' ' . $row->user_from->lastname;
                })
                ->addColumn('status', function($row) {
                    if($row->status == 'succeeded' || $row->status == 'paid' || $row->status == 'success') {
                        return '<div class="badge badge-success">'. $row->status .'</div>';
                    } else if($row->status == 'pending' || $row->status == 'initial') {
                        return '<div class="badge badge-warning">'. $row->status .'</div>';
                    } else {
                        return '<div class="badge badge-danger">'. $row->status .'</div>';
                    }
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="/admin/projects/edit/'. $row->id .'" class="edit datatable-btn datatable-btn-edit"><i class="fa fa-eye"></i></a>
                            <a href="javascript:void(0)" class="edit datatable-btn datatable-btn-remove"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'from', 'status'])
                ->toJson();
    }
}
