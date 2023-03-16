<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Employer;
use App\Models\User;
use App\Http\Requests\Employer\UpdateProfileRequest;

class EmployersController extends Controller
{
    public function save_role_form(Request $request) {
        $request->validate([
            'id' => 'required|exists:user,id',
            'display_name' => 'required|min:6',
            'contactno' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        $id = $request->id;

        $employer = Employer::create([
            'user_id' => $id,
            'display_name' => $request->display_name,
            'contactno' => $request->contactno,
            'number_employees' => $request->number_employees,
            'tagline' => $request->tagline,
            'description' => $request->description,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

        if($employer) {
            return response()->json([
                'status' => true,
                'message' => 'Employer Account Successfully Added.',
                'role' => 'employer',
                'employer' => $employer
            ], 201);
        }
    }

    public function update_profile(UpdateProfileRequest $request) {
        if(!$request->header('user_id')) return response()->json(['status' => false, 'message' => 'Forbidden.'], 403);
        $employer = Employer::where('user_id', $request->header('user_id'))->firstOr(function() {
            return response()->json([
                'status' => false,
                'message' => "Employer doesn't exist"
            ]);
        });

        $employer_data = array_diff($request->validated(), [$request->firstname, $request->lastname, $request->middlename, $request->username, $request->email]);
        $employer_update = $employer->update($employer_data);

        $employer_user_update = $employer->user()->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'middlename' => $request->middlename,
            'username' => $request->username,
            'email' => $request->email,
        ]);

        if($employer_update && $employer_user_update) return response()->json(['status' => true, 'message' => 'User updated successfully.']);
        return response()->json(['status' => false, 'message' => 'Something went wrong']);
    }
}
