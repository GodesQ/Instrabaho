<?php

namespace App\Http\Controllers\Web\Accounting;

use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Accounting;

use App\Http\Requests\Accounting\StoreAccountingRequest;
use App\Http\Requests\Accounting\UpdateAccountingRequest;


use Yajra\DataTables\Facades\DataTables;

class AccountingController extends Controller
{
    public function dashboard(Request $request) {
        return view('AccountingScreens.dashboard.dashboard');
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
                    $btn = '<a class="edit-skill-btn datatable-btn datatable-btn-edit" href="/admin/accounting/edit/'. $row->id .'">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="javascript:void(0)" class="edit datatable-btn datatable-btn-remove"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'status'])
                ->toJson();
    }

    public function create() {
        return view('AdminScreens.accounting.create');
    }

    public function store(StoreAccountingRequest $request) {
        $data = array_diff($request->validated(), [$request->password]);
        $accounting = Accounting::create(array_merge($data, ['password' => Hash::make($request->password)]));

        return redirect()->route('admin.accounting.edit', $accounting->id)->with('success', 'Accounting Successfully Created.');
    }

    public function edit(Request $request) {
        $accounting = Accounting::where('id', $request->id)->firstOrFail();
        return view('AdminScreens.accounting.edit', compact('accounting'));
    }

    public function update(UpdateAccountingRequest $request) {
        $accounting = Accounting::where('id', $request->id)->firstOrFail();
        $update_accounting = $accounting->update($request->validated());
        if($update_accounting) return back()->with('success', 'Accounting Successfully Updated.');
    }
}
