<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Withdrawal;
use Yajra\DataTables\Facades\DataTables;

class WithdrawalController extends Controller
{
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
}
