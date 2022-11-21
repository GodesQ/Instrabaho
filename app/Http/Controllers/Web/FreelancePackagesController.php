<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FreelancePackage;
use App\Models\Freelancer;
use App\Http\Requests\FreelancerPackage\StoreFreelancePackageRequest;
use App\Http\Requests\FreelancerPackage\UpdateFreelancePackageRequest;

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
                    $btn = '<a href="/admin/freelancer_packages/edit/'. $row->id .'" class="edit datatable-btn datatable-btn-edit"><i class="fa fa-edit"></i></a>
                            <a href="javascript:void(0)" class="edit datatable-btn datatable-btn-remove"><i class="fa fa-trash"></i></a>';
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

    public function update(UpdateFreelancePackageRequest $request) {
        $update = FreelancePackage::where('id', $request->id)->update(array_merge($request->validated(), [
            'isProfileFeatured' => $request->isProfileFeatured ? $request->isProfileFeatured : 0
        ]));

        if($update) return back()->with('success', 'Package update successfully');
    }

    public function create() {
        return view('AdminScreens.freelance_packages.create_freelance_package');
    }

    public function store(StoreFreelancePackageRequest $request) {
        $store = FreelancePackage::create(array_merge($request->validated(), [
            'isProfileFeatured' => $request->isProfileFeatured ? $request->isProfileFeatured : 0
        ]));

        if($store) return redirect('/admin/freelancer_packages')->with('success', 'Package added successfully');
    }

    public function freelance_packages() {
        $packages = FreelancePackage::all();
        return view('CustomerScreens.packages.freelancer-package', compact('packages'));
    }

}