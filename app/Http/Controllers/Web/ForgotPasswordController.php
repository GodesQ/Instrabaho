<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use App\Mail\ForgotPasswordMail;

use App\Models\ForgotPassword;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function send_forgot_form(Request $request) {
        $request->validate([
            "email" => "required|email|exists:user"
        ]);
        
        $token = Str::random(64);

        $create = ForgotPassword::create([
            'email' => $request->email,
            'token' => $token,
        ]);

        Mail::to($request->email)->send(new ForgotPasswordMail($token, $request->email));
        return redirect('/forgot-message')->with('success', 'We sent an email to your email address');
    }

    public function forgot_message() {
        return view('AllScreens.misc.forgot-password-message');
    }

    public function forgot_reset_form(Request $request) {
        $token = $request->verify_token;
        $email = $request->email;
        return view('AllScreens.auth.forgot_password_form', compact('token', 'email'));
    }

    public function submit_reset_form(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:user',
            'password' => 'required',
            'password_confirmation' => 'required_with:password|same:password',
        ]);

        $dataExists = ForgotPassword::where('email', $request->email)->where('token', $request->verify_token)->exists();

        if($dataExists) {
            $patient = User::where('email', $request->email)->update(['password' => Hash::make($request->password), 'isVerify' => 1]);;
            ForgotPassword::where(['email'=> $request->email])->delete();
            return redirect('/login')->with('success', 'Your password has been changed!');
        }
        return back()->with('fail', 'Invalid Data');
    }
}