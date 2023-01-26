<?php

namespace App\Http\Controllers\Web\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Accounting;

use Yajra\DataTables\Facades\DataTables;

class AccountingController extends Controller
{
    public function dashboard(Request $request) {

    }

    public function index(Request $request) {
        return view('AdminScreens.accounting.index');
    }

    public function data_table(Request $request) {
        $data = Accounting::latest('id')->get();
        return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row) {
                    if($row->is_active) return '<div class="badge badge-primary p-50">Active</div>';
                    return '<div class="badge badge-warning p-50">Not Active</div>';
                })
                ->addColumn('action', function($row) {
                    $btn = '<button class="edit-skill-btn datatable-btn datatable-btn-edit" data-toggle="modal" data-target="#edit">
                                <i class="fa fa-edit"></i>
                            </button>
                            <a href="javascript:void(0)" class="edit datatable-btn datatable-btn-remove"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'status'])
                ->toJson();
    }
}
