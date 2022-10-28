<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EmployerPackage;

use Yajra\DataTables\Facades\DataTables;

class EmployerPackagesController extends Controller
{   
    public function index(Request $request) {
        return view('AdminScreens.employer_packages.employer_packages');
    }

    public function data_table(Request $request) {
        if($request->ajax()) {
            $data = EmployerPackage::select('*');
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){     
                    $btn = '<a href="/admin/employer_packages/edit/'. $row->id .'" class="edit btn btn-primary"><i class="fa fa-edit"></i></a>
                            <a href="javascript:void(0)" class="edit btn btn-danger"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
    }

    public function edit(Request $request) {
        $package = EmployerPackage::where('id', $request->id)->first();
        return view('AdminScreens.employer_packages.edit_employer_package', compact('package'));
    }

    public function update(Request $request) {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'total_projects' => 'required|numeric',
            'total_feature_projects' => 'required|numeric',
            'expiry_days' => 'required|numeric'
        ]);

        $update = EmployerPackage::where('id', $request->id)->update([
            'name' => $request->name,
            'price' => $request->price,
            'total_projects' => $request->total_projects,
            'total_feature_projects' => $request->total_feature_projects,
            'expiry_days' => $request->expiry_days,
            'isProfileFeatured' => $request->isProfileFeatured ? $request->isProfileFeatured : 0
        ]);

        if($update) {
            return back()->with('success', 'Package update successfully');
        }
        
    }

    public function create() {
        return view('AdminScreens.employer_packages.create_employer_package');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'total_projects' => 'required|numeric',
            'total_feature_services' => 'required|numeric',
            'expiry_days' => 'required|numeric'
        ]);

        $store = EmployerPackage::create([
            'name' => $request->name,
            'price' => $request->price,
            'total_projects' => $request->total_projects,
            'total_feature_projects' => $request->total_feature_projects,
            'expiry_days' => $request->expiry_days,
            'isProfileFeatured' => $request->isProfileFeatured ? $request->isProfileFeatured : 0
        ]);

        if($store) {
            return redirect('/admin/employer_packages')->with('success', 'Package added successfully');
        }
    }
    
    public function employer_package() {
        $packages = EmployerPackage::all();
        return view('CustomerScreens.packages.employer-package', compact('packages'));
    }
}