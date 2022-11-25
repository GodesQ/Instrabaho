<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Auth;

use App\Models\Admin;

class AdminAuthController extends Controller
{
    public function login() {
        return view('AdminScreens.admin_auth.login');
    }

    public function save_login(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if(!Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password])) {
            return back()->with('errors', 'Your email or password is incorrect. Please Try Again.');
        }

        $admin = Auth::guard('admin')->user();

        session()->put([
            'id' => $admin->id,
            'username' => $admin->username,
            'role' => $admin->role
        ]);

        return redirect('/admin')->with('success', 'Login Successfully');
    }

    public function logout(Request $request) {
        if (session()->has(['role']) && session()->has(['id'])) {
            session()->flush();
            return redirect('/admin/login')->with('success', "Logout Successfully.");
        }
    }
}
