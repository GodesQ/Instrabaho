<?php

namespace App\Http\Controllers\Web\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Accounting;

class AccountingAuthController extends Controller
{
    public function login(Request $request) {
        return view('AccountingScreens.auth.login');
    }

    public function save_login(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $accounting = Accounting::where('username', $request->username)->first();

        if(!$accounting) return back()->withErrors("Your Email doesn't exists.");

        if(Hash::check($request->password, $accounting->password)) {
            session()->put([
                'id' => $accounting->id,
                'username' => $accounting->username,
                'role' => 'accounting'
            ]);
        } else {
            return back()->withErrors("Your Email doesn't exists.");
        }

        return redirect()->route('accounting.dashboard')->with('success', 'Login Successfully');
    }
}
