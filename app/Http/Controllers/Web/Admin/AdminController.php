<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Yajra\DataTables\Facades\DataTables;
use App\Models\Admin;

class AdminController extends Controller
{
    public function dashboard(Request $request) {
        return view('AdminScreens.dashboard.admin_dashboard');
    }

    public function index() {
        return view('AdminScreens.admins.admins');
    }

    public function data_table(Request $request) {
        abort_if(!$request->ajax(), 404);

        $data = Admin::all();
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
