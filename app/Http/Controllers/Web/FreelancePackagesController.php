<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FreelancePackage;
use App\Models\Freelancer;

use Yajra\DataTables\Facades\DataTables;

class FreelancePackagesController extends Controller
{
    public function index(Request $request) {
        return view('AdminScreens.freelance_packages.freelance_packages');
    }

    public function data_table(Request $request) {
        if($request->ajax()) {
            $data = FreelancePackage::select('*');
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){     
                    $btn = '<a href="/admin/freelancer_packages/edit/'. $row->id .'" class="edit btn btn-primary"><i class="fa fa-edit"></i></a>
                            <a href="javascript:void(0)" class="edit btn btn-danger"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
    }

    public function edit(Request $request) {
        $package = FreelancePackage::where('id', $request->id)->first();
        return view('AdminScreens.freelance_packages.edit_freelance_package', compact('package'));
    }

    public function update(Request $request) {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'total_projects' => 'required|numeric',
            'total_services' => 'required|numeric',
            'total_feature_services' => 'required|numeric',
            'expiry_days' => 'required|numeric'
        ]);

        $update = FreelancePackage::where('id', $request->id)->update([
            'name' => $request->name,
            'price' => $request->price,
            'total_projects' => $request->total_projects,
            'total_services' => $request->total_services,
            'total_feature_services' => $request->total_feature_services,
            'expiry_days' => $request->expiry_days,
            'isProfileFeatured' => $request->isProfileFeatured ? $request->isProfileFeatured : 0
        ]);

        if($update) {
            return back()->with('success', 'Package update successfully');
        }
        
    }

    public function create() {
        return view('AdminScreens.freelance_packages.create_freelance_package');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'total_projects' => 'required|numeric',
            'total_services' => 'required|numeric',
            'total_feature_services' => 'required|numeric',
            'expiry_days' => 'required|numeric'
        ]);

        $store = FreelancePackage::create([
            'name' => $request->name,
            'price' => $request->price,
            'total_projects' => $request->total_projects,
            'total_services' => $request->total_services,
            'total_feature_services' => $request->total_feature_services,
            'expiry_days' => $request->expiry_days,
            'isProfileFeatured' => $request->isProfileFeatured ? $request->isProfileFeatured : 0
        ]);

        if($store) {
            return redirect('/admin/freelancer_packages')->with('success', 'Package added successfully');
        }
    }

    public function freelance_packages() {
        $packages = FreelancePackage::all();
        return view('CustomerScreens.packages.freelancer-package', compact('packages'));
    }

}