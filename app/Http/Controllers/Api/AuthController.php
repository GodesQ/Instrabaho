<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

use App\Http\Requests\UserAuth\RegisterRequest;

class AuthController extends Controller
{
    //
    public function login(Request $request) {

        if (Auth::guard('user')->user()) return response()->json([
            'status' => false,
            'message' => 'Already Authenticated',
        ]);

        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if(!Auth::guard('user')->attempt([$fieldType => $request->email, 'password' => $request->password, 'isVerify' => 1])) {
            return response()->json([
                'status' => false,
                'message' => 'Email & Password does not match with our record.',
            ], 401);
        }

        $user = Auth::guard('user')->user();

        return response()->json([
            'status' => true,
            'message' => 'User Logged In Successfully',
            'user' => $user,
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
        if($validator->fails()) return response()->json($validator->errors(), 401);

        return response()->json();
    }

    public function logout(Request $request) {
        $user = Auth::guard()->user();
        return response()->json($user);
        # delete token
        $user->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logout Successfully'
        ], 200);
    }
}
