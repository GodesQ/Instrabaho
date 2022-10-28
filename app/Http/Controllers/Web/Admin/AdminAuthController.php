<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

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

        $admin = Admin::where('username', $request->username)->first();
        if(!$admin) {
            return back()->with('fail', 'Username does not exist.');
        }

        if(!Hash::check($request->password, $admin->password)) {
            return back()->with('fail', 'Password is incorrect.');
        }

        session()->put([
            'id' => $admin->id,
            'username' => $admin->username,
            'role' => 'admin'
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