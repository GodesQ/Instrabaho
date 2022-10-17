<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Freelancer;
use App\Models\Addon;

class AddonsController extends Controller
{
    //
    public function index() {
        $user_id = session()->get('id');
        $freelancer = Freelancer::where('user_id', $user_id)->first();
        $addons = Addon::where('user_role_id', $freelancer->id)->latest('id')->cursorPaginate(8);
        return view('addons.addons', compact('addons'));
    }
 
    public function create() {
        return view('addons.create-addon');
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
            'user_role_id' => $freelancer->id,
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
       return view('addons.edit-addon', compact('addon'));
    }

    public function update(Request $request) {
        $id = $request->id;
        $save = Addon::where('id', $request->id)->update([
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
}