<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Freelancer;
use App\Models\Users;

class FreelancersController extends Controller
{
    //

    public function freelancers(Request $request) {
        $freelancers = Freelancer::with('user', 'freelancer_skills')->get();
        return response()->json([
            'status' => true,
            'freelancers' => $freelancers
        ], 200);
    }

    public function save_role_form(Request $request) {
        $request->validate([
            'display_name' => 'required',
            'freelancer_type' => 'required',
            'hourly_rate' => 'required',
            'contactno' => 'required',
            'gender' => 'required',
            'tagline' => 'required',
            'description' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        $id = session()->get('id');

        $save = Freelancer::create([
            'user_id' => $id,
            'display_name' => $request->display_name,
            'freelancer_type' => $request->freelancer_type,
            'hourly_rate' => $request->hourly_rate,
            'contactno' => $request->contactno,
            'gender' => $request->gender,
            'tagline' => $request->tagline,
            'description' => $request->description,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

    }
}
