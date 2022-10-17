<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EmployerPackage;

class EmployerPackagesController extends Controller
{
    public function employer_package() {
        $packages = EmployerPackage::all();
        return view('packages.employer-package', compact('packages'));
    }
}