<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Luigel\Paymongo\Facades\Paymongo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

use App\Models\Withdrawal;
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

use Yajra\DataTables\Facades\DataTables;

use App\Http\Requests\Withdrawal\UpdateWithdrawalStatus;
use App\Http\Requests\Withdrawal\PostWithdrawal;

use App\Mail\PaidWithdrawal;


class WithdrawalController extends Controller
{

    public function withdrawals(PostWithdrawal $request) {
        $amount = $request->amount;
        $user = User::where('id', session()->get('id'))->firstOr(function() {
            return back()->with('fail', 'Invalid User');
        });

        switch ($request->payment_method) {
            case 'gcash':
                DB::beginTransaction();
                try {
                    $transaction_code = 'TXN-ID' . '-' . strtoupper(Str::random(16));
                    $transaction = Transaction::create([
                        'name_of_transaction' => 'Withdrawal',
                        'transaction_type' => 'withdraw',
                        'transaction_code' => $transaction_code,
                        'amount' => $amount,
                        'sub_amount' => $amount,
                        'from_id' => $user->id,
                        'to_id' => 0,
                        'payment_method' => $request->payment_method,
                        'status' => 'pending'
                    ]);

                    $reference_no = 'REF-NO' . '-' . strtoupper(Str::random(16));
                    $withdrawal = Withdrawal::create([
                        'reference_no' => $reference_no,
                        'user_id' => $user->id,
                        'transaction_code' => $transaction->transaction_code,
                        'txn_id' => $transaction->id,
                        'withdrawal_type' => $request->payment_method,
                        'sub_amount' => $amount,
                        'total_amount' => $amount,
                        'status' => 'pending'
                    ]);

                    $gcash_withdrawal = GcashWithdrawal::create([
                        'withdrawal_id' => $withdrawal->id,
                        'gcash_number' => $request->gcash_number,
                    ]);

                } catch(\Exception $e)
                {
                    DB::rollback();
                    throw $e;
                }
                return back()->with('success', 'Withdraw Request Successfully Send');
            case 'card':

                break;
            default:

                break;
        }


    }

    public function index(Request $request) {
        return view('AdminScreens.withdrawals.withdrawals');
    }

    public function data_table(Request $request) {
        abort_if(!$request->ajax(), 404);

        $data = Withdrawal::select('*')->with('user', 'transaction');
        return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function($row) {
                    return $row->user->firstname . ' ' . $row->user->lastname;
                })
                ->addColumn('status', function($row) {
                    if($row->status == 'succeeded' || $row->status == 'paid' || $row->status == 'success') {
                        return '<div class="badge badge-success">'. $row->status .'</div>';
                    } else if($row->status == 'pending' || $row->status == 'initial') {
                        return '<div class="badge badge-warning">'. $row->status .'</div>';
                    } else if($row->status == 'processing') {
                        return '<div class="badge badge-primary">'. $row->status .'</div>';
                    } else {
                        return '<div class="badge badge-danger">'. $row->status .'</div>';
                    }
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="withdrawals/show/'. $row->id .'" class="edit datatable-btn datatable-btn-edit"><i class="fa fa-eye"></i></a>
                            <a href="javascript:void(0)" class="edit datatable-btn datatable-btn-remove"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'user', 'status'])
                ->toJson();
    }

    public function show(Request $request) {
        $withdrawal = Withdrawal::where('id', $request->id)->firstOrFail();
        return view('AdminScreens.withdrawals.withdrawal', compact('withdrawal'));
    }

    public function update_status(UpdateWithdrawalStatus $request) {
        if(!$request->ajax()) return response()->json(['status' => false, 'message' => 'Something went wrong, Please try again.']);

        $withdraw_data = Withdrawal::where('id', $request->id)->first();
        $user_wallet = UserWallet::where('user_id', $withdraw_data->user_id)->firstOr(function() {
            return response()->json(['status' => false, 'message' => 'User wallet not found.']);
        });

        switch ($request->status) {
            case 'paid':
                Mail::to($withdraw_data->user->email)->send(new PaidWithdrawal($withdraw_data->user));
                break;
            case 'processing':

                break;

            case 'failed':
                break;
        }

        $update_withdraw = $withdraw_data->update([
            'status' => $request->status,
        ]);

        $withdraw_data->transaction->update([
            'status' => $request->status,
        ]);

        if($update_withdraw) return response()->json(['status' => true, 'message' => 'Status change successfully']);
    }
}
