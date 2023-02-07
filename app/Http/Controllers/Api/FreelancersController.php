<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Freelancer;
use App\Models\User;
use App\Http\Requests\Freelancer\UpdateProfileRequest;

class FreelancersController extends Controller
{
    public function update_profile(UpdateProfileRequest $request) {
        if($request->header('user_id')) response()->json(['status' => false, 'message' => "Forbidden."], 403);

        $freelancer = Freelancer::where('user_id', $request->header('user_id'))->firstOr(function () {
            return response()->json(['status' => false, 'message' => "Freelancer doesn't exist."], 406);
        });

        $freelancer_data = array_diff($request->validated(), [$request->username, $request->firstname, $request->lastname, $request->middlename, $request->email]);

        $freelancer_update = $freelancer->update($freelancer_data);
        $freelancer_user_update = $freelancer->user()->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'middlename' => $request->middlename,
            'username' => $request->username,
        ]);
        return response()->json(['status' => true, 'message' => 'User updated successfully'], 200);
    }

    public function freelancers(Request $request) {
        $freelancers = Freelancer::with('user', 'freelancer_skills')->get();
        return response()->json([
            'status' => true,
            'freelancers' => $freelancers
        ], 200);
    }

    public function fetch_freelancers(Request $request) {

        // data filters
        $title = $request->input('title');
        $address = $request->input('address');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $my_range = $request->input('hourly_rate');
        $radius = $request->input('radius');
        $result = $request->input('result');
        $sort = $request->input('sort');

        $freelancer_skills = $request->input('skills') ? json_decode($request->input('skill')) : [];
        $freelance_type = $request->input('freelance_type') ? json_decode($request->input('freelance_type')) : [];

        $freelancers = Freelancer::select('*')->when($title, function ($q) use ($title) {
            return $q->where(DB::raw('lower(display_name)'), 'like', '%' . strtolower($title) . '%')
                    ->orWhere(DB::raw('lower(tagline)'), 'like', '%' . strtolower($title) . '%')
                    ->orWhere(DB::raw('lower(description)'), 'like', '%' . strtolower($title) . '%')
                    ->orWhereHas('user', function ($query) use ($title) {
                        $query->where(DB::raw('lower(username)'), 'like', '%' . strtolower($title) . '%')
                            ->orWhere(DB::raw('lower(firstname)'), 'like', '%' . strtolower($title) . '%');
                    });
        })
        ->when($latitude and $longitude, function ($q) use ($latitude, $longitude, $radius, $sort) {
            return $q->addSelect(DB::raw("6371 * acos(cos(radians(" . $latitude . "))
            * cos(radians(user_freelancer.latitude))
            * cos(radians(user_freelancer.longitude) - radians(" . $longitude . "))
            + sin(radians(" .$latitude. "))
            * sin(radians(user_freelancer.latitude))) AS distance"))->having('distance', '<=', $radius)->orderBy("distance", 'asc');
        })
        ->with('user', 'freelancer_skills')
        ->get();

        return response()->json([
            'status' => $freelancers->count() > 0 ? true : false,
            'freelancer_count' => $freelancers->count(),
            'freelancers' => $freelancers
        ], 200);

    }

    public function save_role_form(Request $request) {
        $request->validate([
            'id' => 'required|exists:user,id',
            'display_name' => 'required',
            'hourly_rate' => 'required|integer',
            'contactno' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        $id = $request->header('user_id');
        if(!$id) return response()->json(['status' => false], 403);

        $freelancer = Freelancer::where('user_id', $id)->first();

        if($freelancer) {
            return response()->json([
                'status' => false,
                'message' => 'The Freelancer Account Already Exists.'
            ], 406);
        }

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

        if($save) {
            return response()->json([
                'status' => true,
                'message' => 'Freelancer Account Successfully Added.',
                'role' => 'freelancer'
            ], 201);
        }

    }
}
