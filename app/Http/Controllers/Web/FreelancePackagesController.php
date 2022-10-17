<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FreelancePackage;
use App\Models\Freelancer;

class FreelancePackagesController extends Controller
{
    //
    public function freelance_packages() {
        $packages = FreelancePackage::all();
        return view('packages.freelancer-package', compact('packages'));
    }
}