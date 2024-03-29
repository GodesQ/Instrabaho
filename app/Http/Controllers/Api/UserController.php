<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Http\Requests\User\ChangePasswordRequest;

class UserController extends Controller
{
    public function change_user_picture(Request $request) {

        if(!$request->header('user_id')) return response()->json(['status' => false, 'message' => 'Forbidden'], 403);

        $profile = User::where('id', $request->header('user_id'))->first();
        $profile_image = $request->old_profile_picture;
        $cover_image = $request->old_cover_picture;

        if($request->hasFile('new_profile_picture')) {
            //remove first the old image
            $image = public_path('/images/user/profile/') . $request->old_profile_picture;
            $remove_image = @unlink($image);
            //store the new image
            $file = $request->file('new_profile_picture');
            $profile_image = $file->getClientOriginalName();
            // dd($profile_image);
            $save_file = $file->move(public_path().'/images/user/profile', $profile_image);
            session()->put('profile_image', $profile_image);
        }

        if(isset($request->new_cover_picture)) {
            //remove first the old image
            $image = public_path('/images/user/cover/') . $request->old_cover_picture;
            $remove_image = @unlink($image);
            //store the new image
            $file = $request->file('new_cover_picture');
            $cover_image = $file->getClientOriginalName();
            $save_file = $file->move(public_path().'/images/user/cover', $cover_image);
        }

        $profile->profile_image = $profile_image;
        $profile->cover_image = $cover_image;
        $save = $profile->save();

        if($save) return response()->json([
            'status' => true,
            'message' => 'Image Successfully Updated.'
        ], 200);
    }

    public function user_change_password(ChangePasswordRequest $request) {

        if(!$request->header('user_id')) return response()->json(['status' => false, 'message' => 'Forbidden'], 403);

        $user = User::where('id', $request->header('user_id'))->first();

        if(!Hash::check($request->old_password, $user->password)) return response()->json(['status' => false, 'message' => 'Sorry your old password is incorrect.']);
        if($request->confirm_password != $request->new_password) return response()->json(['status' => false, 'message' => "Sorry your password didn't match to confirm password."]);

        $user->password = Hash::make($request->new_password);
        $save = $user->save();

        if($save) return response()->json([
            'status' => true,
            'message' => 'Password Successfully Updated.'
        ], 200);

        return response()->json([
            'status' => false,
            'message' => 'Fail to change password'
        ], 409);

    }
}
