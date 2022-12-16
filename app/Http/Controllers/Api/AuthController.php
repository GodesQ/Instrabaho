<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

use App\Http\Requests\UserAuth\RegisterRequest;

class AuthController extends Controller
{
    //
    public function login(Request $request) {
        return response()->json($request->all());
    }

    public function register(Request $request) {

        $validator = \Validator::make($request->all(), [
            'firstname' => 'required|min:2|max:15',
            'lastname' => 'required|min:2|max:15',
            'username' => 'required|unique:user|max:15|alpha',
            'email' => 'required|unique:user|email',
            'password' => 'min:3|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:3'
        ]);

        # if the requested input have an error
        if($validator->fails())  return response()->json($validator->errors());

        return response()->json($request->all());
    }

}
