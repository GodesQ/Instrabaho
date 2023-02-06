<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\VerifyAccount;

use App\Models\User;
use App\Models\Freelancer;
use App\Models\Employer;

use App\Http\Requests\UserAuth\RegisterRequest;

class AuthController extends Controller
{
    //
    public function login(Request $request) {

        // return response()->json(Auth::guard('user')->check());

        if(Auth::guard('user')->check()) {
            return response()->json([
                'status' => false,
                'message' => 'You are already authorized'
            ]);
        }

        #validate requests
        $validator = \Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required', 'min:3'],
            'role' => ['required', 'in:freelancer,employer']
        ]);

        # if the requested input have an error
        if($validator->fails()) return response()->json([
            'message' => $validator->errors()
        ], 401);

        # check if the request is email or username type
        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if(!Auth::guard('user')->attempt([$fieldType => $request->email, 'password' => $request->password, 'isVerify' => 1])) {
            return response()->json([
                'status' => false,
                'message' => 'Email & Password does not match with our record.',
            ], 401);
        }

        $user = Auth::guard('user')->user();

        $user_freelancer = Freelancer::where('user_id', $user->id)->first();
        $user_employer = Employer::where('user_id', $user->id)->first();

        $redirect_status = 1; // redirect to freelancer role dashboard

        //check if the user has a freelancer data
        if($request->role == 'freelancer' && !$user_freelancer) $redirect_status = 0;

        //check if the user has a employer data
        if($request->role == 'employer' && !$user_employer) $redirect_status = 0;

        return response()->json([
            'status' => $redirect_status,
            'message' => 'User Logged In Successfully',
            'user' => $user,
            'user_role_data' => $request->role == 'freelancer' ? $user_freelancer : $user_employer,
            'role' => $request->role,
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ], 200);
    }

    public function register(Request $request) {

        $validator = \Validator::make($request->all(), [
            'firstname' => ['required', 'min:2', 'max:15'],
            'lastname' => ['required', 'min:2', 'max:15'],
            'username' => ['required', 'unique:user', 'max:15'],
            'email' => ['required', 'unique:user', 'email'],
            'password' => ['required', 'required_with:password_confirmation', 'same:password_confirmation'],
            'password_confirmation' => ['required', 'min:3']
        ]);

        # if the requested input have an error
        if($validator->fails()) return response()->json([
            'message' => $validator->errors()
        ], 401);

        $save = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'middlename' => $request->middlename,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'isVerify' => false,
        ]);

        # details for sending email to worker
        $details = [
            'title' => 'Verification email from INSTRABAHO',
            'email' => $request->email,
            'username' => $request->username,
        ];

        // SEND EMAIL FOR VERIFICATION
        Mail::to($request->email)->send(new VerifyAccount($details));

        return response()->json([
            'status' => true,
            'message' => 'Register Successfully. Validate Email Now',
            'email' => $request->email
        ], 201);
    }

    public function logout(Request $request) {
        $user = Auth::guard()->user();

        # delete token
        $user->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logout Successfully',
        ], 200);
    }
}
