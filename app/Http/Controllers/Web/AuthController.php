<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyAccount;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Freelancer;
use App\Models\Employer;

class AuthController extends Controller
{
    public function login() {
        return view('AllScreens.auth.login');
    }

    public function save_login(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);


        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return back()->withErrors('Your email or password is incorrect. Please Try Again.');
        }

        $user = Auth::user();
        if(!$user->isVerify)  return back()->withErrors('Please verify your email address.');

        $request->session()->put([
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'role' => $request->role,
            'profile_image' => $user->profile_image
        ]);

        $user_freelancer = Freelancer::where('user_id', $user->id)->first();
        $user_employer = Employer::where('user_id', $user->id)->first();

        //check if the user has a freelancer data
        if($request->role == 'freelancer' && !$user_freelancer) return redirect()->route('freelancer.role_form')->with('success', 'Login Successfully');

        //check if the user has a employer data
        if($request->role == 'employer' && !$user_employer) return redirect()->route('employer.role_form', 'Login Successfully');

        return redirect('/')->with('success', 'Login Successfully');
    }

    public function register() {
        return view('AllScreens.auth.register');
    }

    public function save_register(Request $request) {

        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'middlename' => 'required',
            'username' => 'required|unique:user',
            'email' => 'required|unique:user',
            'password' => 'required'
        ]);

        $save = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'middlename' => $request->middlename,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'isVerify' => false,
        ]);

        $details = [
            'title' => 'Verification email from INSTRABAHO',
            'email' => $request->email,
            'username' => $request->username,
        ];

        // SEND EMAIL FOR VERIFICATION
        Mail::to($request->email)->send(new VerifyAccount($details));

        if($save) {
            return redirect('/verify-message');
        }
    }

    public function verify_email(Request $request)
    {
        $user = User::where('email', '=', $request->verify_email)->first();
        $user->isVerify = true;
        $save = $user->save();

        if ($save) {
            return redirect('/login')->with(
                'success',
                'Your Email Address was successfully verified.'
            );
        }
    }

    public function verify_message() {
        return view('AllScreens.misc.verify-message');
    }

    public function logout() {
        if (session()->has(['role']) && session()->has(['id'])) {
            session()->flush();
            return redirect('/login')->with('success', "Logout Successfully.");
        }
    }

    public function change_login(Request $request) {
        $role = session()->get('role');
        if($role == 'freelancer') {
            session()->put('role', 'employer');
            return redirect('employer/dashboard')->with('success', 'Login Successfully');
        }

        if($role == 'employer') {
            session()->put('role', 'freelancer');
            return redirect('freelancer/dashboard')->with('success', 'Login Successfully');
        }
    }
}
