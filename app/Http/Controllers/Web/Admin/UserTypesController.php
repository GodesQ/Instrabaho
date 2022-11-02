<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;
use App\Models\UserType;

class UserTypesController extends Controller
{
    public function index(Request $request) {
        return view('AdminScreens.user_types.user_types');
    }

    public function data_table(Request $request) {
        abort_if(!$request->ajax(), 403);
        $data = UserType::select('*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('created_at', function($row) {
                return date_format($row->created_at, 'F d, Y');
            })
            ->addColumn('action', function($row) {
                $btn = '<button onclick="getUserType('.$row->id.')" class="edit-skill-btn datatable-btn datatable-btn-edit" data-toggle="modal" data-target="#edit">
                            <i class="fa fa-edit"></i>
                        </button>
                        <a href="javascript:void(0)" class="edit datatable-btn datatable-btn-remove"><i class="fa fa-trash"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function store(Request $request) {
        $request->validate([
            'user_type' => 'required',
            'slug' => 'required|alpha-dash'
        ]);

        UserType::create([
            'user_type' => $request->user_type,
            'slug' => $request->slug
        ]);

        return back()->with('success', 'Create User Type Successfully');
    }

    public function edit(Request $request) {
        $user_type =  UserType::where('id', $request->id)->first();
        return response()->json($user_type);
    }

    public function update(Request $request) {
        $request->validate([
            'id' => 'required|exists:user_types,id',
            'user_type' => 'required',
            'slug' => 'required'
        ]);

        UserType::where('id', $request->id)->update([
            'user_type' => $request->user_type,
            'slug' => $request->slug
        ]);

        return back()->with('success', 'Update User Type Successfully');
    }
}
