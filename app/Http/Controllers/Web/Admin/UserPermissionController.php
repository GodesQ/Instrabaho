<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\UserPermission;
use App\Models\UserType;

use Yajra\DataTables\Facades\DataTables;

class UserPermissionController extends Controller
{
    public function permission(Request $request) {
        return view('AdminScreens.user_permission.user_permission');
    }

    public function data_table(Request $request) {
        $data = UserPermission::select('*');
        return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('roles', function ($row) {
                    return str_replace('|', ', ', $row->roles);
                })
                ->addColumn('created_at', function($row) {
                    return date_format($row->created_at, 'F d, Y');
                })
                ->addColumn('action', function($row) {
                    $btn = '<a href="/admin/user_permissions/edit/'. $row->id .'" class="edit datatable-btn datatable-btn-edit"><i class="fa fa-edit"></i></a>
                            <a href="javascript:void(0)" class="edit datatable-btn datatable-btn-remove"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();;
    }

    public function create() {
        $user_types = UserType::all();
        return view('AdminScreens.user_permission.create-permission', compact('user_types'));
    }

    public function store(Request $request) {
        $request->validate([
            'permission' => 'required|min:5',
        ]);

        $roles = implode('|', $request->roles);
        $save = UserPermission::create([
            'permission' => $request->permission,
            'roles' => $roles
        ]);

        return redirect()->route('admin.user_permissions')->with('success', 'Create Permission Successfully');
    }

    public function edit(Request $request) {
        $user_types = UserType::all();
        $permission = UserPermission::where('id', $request->id)->firstOrFail();
        return view('AdminScreens.user_permission.edit-permission', compact('user_types', 'permission'));
    }

    public function update(Request $request) {
        $request->validate([
            'permission' => 'required|min:5',
        ]);

        $roles = implode('|', $request->roles);
        $save = UserPermission::where('id', $request->id)->update([
            'permission' => $request->permission,
            'roles' => $roles
        ]);
        return back()->with('success', 'Create Permission Successfully');
    }
}
