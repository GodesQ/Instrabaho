<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Freelancer;
use App\Models\Addon;
use App\Http\Requests\Addon\StoreAddonRequest;
use App\Http\Requests\Addon\UpdateAddonRequest;


use Yajra\DataTables\Facades\DataTables;

class AddonsController extends Controller
{
    //
    public function index() {
        $user_id = session()->get('id');
        $freelancer = Freelancer::where('user_id', $user_id)->first();
        $addons = Addon::where('user_role_id', $freelancer->id)->latest('id')->cursorPaginate(8);
        return view('UserAuthScreens.addons.addons', compact('addons'));
    }

    public function create() {
        return view('UserAuthScreens.addons.create-addon');
    }

    public function store(StoreAddonRequest $request, Addon $addon) {

        // check the role of user
        $user_type = base64_decode($request->user_type);
        $user_id = session()->get('id');
        $freelancer_query = Freelancer::query();

        if($user_type == 'admin') {
            $freelancer =  $freelancer_query->where('id', $request->freelancer)->first();
        } else {
            $freelancer = $freelancer_query->where('user_id', $user_id)->first();
        }

        $save = $addon->create(array_merge($request->validated(), [
                'user_role_id' => $freelancer->id,
        ]));

        if($user_type == 'admin' && $save) return redirect()->route('admin.addons')->with('success', 'Addon Created Successfully');
        if($save) {
            return redirect('/addons')->with('success','Addons Added Successfully');
        }
    }

    public function edit(Request $request) {
        $id = $request->id;
        $addon = Addon::where('id', $request->id)->first();
       return view('UserAuthScreens.addons.edit-addon', compact('addon'));
    }

    public function update(UpdateAddonRequest $request) {
        $data = array_diff($request->validated(), [$request->id, $request->freelancer]);
        $id = $request->id;
        $save = Addon::where('id', $request->id)->update(array_merge($data, [
            'user_role_id' => $request->freelancer
        ]));
        return back()->with('success', 'Addon Update Successfully');
    }

    public function destroy(Request $request) {
        $delete = Addon::where('id', $request->id)->delete();
        if($delete) {
            return response()->json([
                'status' => 201,
                'message' => 'Delete Successfully'
            ]);
        }
    }

    public function admin_index() {
        return view('AdminScreens.addons.addons');
    }

    public function data_table(Request $request) {
        abort_if(!$request->ajax(), 403);
        $data = Addon::select('*')->with('freelancer');
        return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('freelancer', function($row) {
                    return $row->freelancer->user->firstname . " " . $row->freelancer->user->lastname;
                })
                ->addColumn('action', function($row) {
                    $btn = '<a href="/admin/addons/edit/'. $row->id .'" class="edit datatable-btn datatable-btn-edit"><i class="fa fa-edit"></i></a>
                            <a id="'. $row->id .'" class="delete-addon datatable-btn datatable-btn-remove"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
    }

    public function admin_edit(Request $request) {
        $addon = Addon::where('id', $request->id)->with('freelancer')->first();
        return view('AdminScreens.addons.edit-addon', compact('addon'));
    }

    public function admin_create(Request $request) {
        return view('AdminScreens.addons.create-addon');
    }
}