<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Employer;
use App\Models\User;

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


}
