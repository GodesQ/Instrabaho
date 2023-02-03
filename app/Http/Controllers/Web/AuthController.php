<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyAccount;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\UserAuth\RegisterRequest;

use App\Models\User;
use App\Models\Freelancer;
use App\Models\Employer;

class AuthController extends Controller
{
    public function login() {
        if(session()->get('role') && session()->get('id')) return redirect('/');
        return view('AllScreens.auth.login');
    }

    public function save_login(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'role' => 'in:freelancer,employer'
        ]);

        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if(!Auth::guard('user')->attempt([$fieldType => $request->email, 'password' => $request->password, 'isVerify' => 1])) {
            return back()->withErrors('Fail to Login Maybe your email or password is invalid. Please Try Again.');
        }

        $user = Auth::guard('user')->user();


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
        if(session()->get('role') && session()->get('id')) return redirect('/');
        return view('AllScreens.auth.register');
    }

    public function save_register(RegisterRequest $request) {
        $data = array_diff($request->validated(), [$request->password_confirmation]);
        $save = User::create(array_merge($data,[
            'middlename' => $request->middlename,
            'password' => Hash::make($request->password),
            'isVerify' => false,
        ]));

        $details = [
            'title' => 'Verification email from INSTRABAHO',
            'email' => $request->email,
            'username' => $request->username,
        ];

        // SEND EMAIL FOR VERIFICATION
         Mail::to($request->email)->send(new VerifyAccount($details));
        if($save) return redirect('/verify-message');
    }

    public function verify_email(Request $request)
    {
        $user = User::where('email', '=', $request->verify_email)->first();
        $user->isVerify = true;
        $save = $user->save();

        if ($save) {
            return redirect('/success-verify-message')->with(
                'success',
                'Your Email Address was successfully verified.'
            );
        }
    }

    public function verify_message() {
        return view('AllScreens.misc.verify-message');
    }

    public function success_verify_message() {
        return view('AllScreens.misc.success-email-verification');
    }

    public function logout() {
        Auth::logout();
        if (session()->has(['role']) && session()->has(['id'])) {
            session()->flush();
            return redirect('/login')->with('success', "Logout Successfully.");
        }
    }

    public function change_login(Request $request) {
        $role = session()->get('role');
        if($role == 'freelancer') {
            session()->put('role', 'employer');
            return redirect()->route('employer.dashboard')->with('success', 'Login Successfully');
        }

        if($role == 'employer') {
            session()->put('role', 'freelancer');
            return redirect()->route('freelancer.dashboard')->with('success', 'Login Successfully');
        }
    }
}
