<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(Request $request) {
        $admin = Auth::user();
        dd($admin);
        return view('AdminScreens.dashboard.admin_dashboard');
    }
}
