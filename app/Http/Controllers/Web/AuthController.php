<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyAccount;

use App\Models\User;
use App\Models\Freelancer;
use App\Models\Employer;

class AuthController extends Controller
{
    //
    public function login() {
        return view('auth.login');
    }

    public function save_login(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $userExist = User::where('email', $request->email)->first();
        
        if(!$userExist) return back()->with('fail', "Sorry your email doesn't exist");

        if(!Hash::check($request->password, $userExist->password)) return back()->with('fail', "Sorry your password is incorrect.");

        if(!$userExist->isVerify) return back()->with('fail', "Please verify your email address to continue.");

        $request->session()->put([
            'id' => $userExist->id,
            'username' => $userExist->username,
            'email' => $userExist->email,
            'role' => $request->role,
            'profile_image' => $userExist->profile_image
        ]);

        $user_freelancer = Freelancer::where('user_id', $userExist->id)->first();
        $user_employer = Employer::where('user_id', $userExist->id)->first();

        //check if the user has a freelancer data
        if($request->role == 'freelancer' && !$user_freelancer) return redirect('/freelancer_role_form')->with('success', 'Login Successfully');
        
        //check if the user has a employer data
        if($request->role == 'employer' && !$user_employer) return redirect('/employer_role_form')->with('success', 'Login Successfully');
        
        return redirect('/')->with('success', 'Login Successfully');
    }

    public function register() {
        return view('auth.register');
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
        return view('misc.verify-message');
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
            return redirect('/dashboard')->with('success', 'Login Successfully');
        }

        if($role == 'employer') {
            session()->put('role', 'freelancer');
            return redirect('/dashboard')->with('success', 'Login Successfully');
        }
    }
}