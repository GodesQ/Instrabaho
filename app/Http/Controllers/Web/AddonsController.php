<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Freelancer;
use App\Models\Addon;

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

    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'price' => 'numeric:required',
            'description' => 'required'
        ]);
        $user_id = session()->get('id');
        $freelancer = Freelancer::where('user_id', $user_id)->first();

        $save = Addon::create([
            'user_role_id' => session()->get('role') == 'freelancer' ? $freelancer->id : $request->freelancer_id,
            'title' => $request->title,
            'price' => $request->price,
            'description' => $request->description
        ]);

        if($save) {
            return redirect('/addons')->with('success','Addons Added Successfully');
        }
    }

    public function edit(Request $request) {
        $id = $request->id;
        $addon = Addon::where('id', $request->id)->first();
       return view('UserAuthScreens.addons.edit-addon', compact('addon'));
    }

    public function update(Request $request) {
        $request->validate([
            'id' => 'required|exists:addons,id',
            'freelancer' => 'required',
            'title' => 'required',
            'price' => 'required|numeric',
            'description' => 'required'
        ]);

        $id = $request->id;
        $save = Addon::where('id', $request->id)->update([
            'user_role_id' => $request->freelancer,
            'title' => $request->title,
            'price' => $request->price,
            'description' => $request->description
        ]);

        return back()->with('success', 'Addon Update Successfully');
    }

    public function destroy(Addon $id) {
        $delete = $id->delete();
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
                            <a href="javascript:void(0)" class="edit datatable-btn datatable-btn-remove"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
    }

    public function admin_edit(Request $request) {
        $addon = Addon::where('id', $request->id)->with('freelancer')->first();
        return view('AdminScreens.addons.edit-addon', compact('addon'));
    }
}
