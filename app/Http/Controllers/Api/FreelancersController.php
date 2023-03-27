<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Freelancer;
use App\Models\User;
use App\Models\FreelancerCertificate;
use App\Models\FreelancerProject;
use App\Models\FreelancerExperience;
use App\Models\FreelancerEducation;
use App\Models\FreelancerSkill;
use App\Models\Skill;

use App\Http\Requests\Freelancer\UpdateProfileRequest;
use App\Http\Requests\Freelancer\StoreSkillRequest;
use App\Http\Requests\Freelancer\StoreProjectRequest;
use App\Http\Requests\Freelancer\StoreCertificateRequest;
use App\Http\Requests\Freelancer\StoreExperienceRequest;
use App\Http\Requests\Freelancer\StoreEducationRequest;

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

    public function fetch_freelancer_skills(Request $request) {
        $role = $request->header('role');
        $user_id = $request->header('user_id');
        if(!$role && !$user_id) return response()->json(['status' => true, 'message' => 'Forbidden.'], 403);

        $freelancer = Freelancer::where('user_id', $user_id)->firstOr(function() {
            return response()->json(['status' => false, 'message' => 'Freelancer Not Found'], 406);
        });

        $skills = Skill::all();
        $freelancer_skills = FreelancerSkill::where('freelancer_id', $freelancer->id)->get();
        return response()->json([
            'skills' => $skills,
            'freelancer_skills' => $freelancer_skills
        ], 200);
    }

    public function store_freelancer_skills(StoreSkillRequest $request) {
        $role = $request->header('role');
        $user_id = $request->header('user_id');
        if(!$role && !$user_id) return response()->json(['status' => true, 'message' => 'Forbidden'], 403);

        if(!isset($request->skills)) return response()->json(['status' => false, 'message' => 'Add atleast one skills'], 406);

        $freelancer = Freelancer::where('user_id', $user_id)->firstOr(function() {
            return response()->json(['status' => false, 'message' => 'Freelancer Not Found'], 406);
        });

        $past_skills = FreelancerSkill::whereIn('freelancer_id', [$freelancer->id])->delete();
        $save = null;

        foreach ($request->skills as $key => $skill) {
            $save = FreelancerSkill::create([
                'freelancer_id' => $freelancer->id,
                'skill_id' => $skill['skill'],
                'skill_percentage' =>$skill['skill_percentage']
            ]);
        }

        if($save) return response()->json(['status' => true, 'message' => 'Freelancer skills save successfully.'], 201);
    }

    public function fetch_freelancer_projects(Request $request) {
        $role = $request->header('role');
        $user_id = $request->header('user_id');
        if(!$role && !$user_id) return response()->json(['status' => true, 'message' => 'Forbidden.'], 403);

        $freelancer = Freelancer::where('user_id', $user_id)->firstOr(function() {
            return response()->json(['status' => false, 'message' => 'Freelancer Not Found'], 406);
        });

        $freelancer_projects = FreelancerProject::where('freelancer_id', $freelancer->id)->get();

        return response()->json([
            'freelancer_projects' => $freelancer_projects
        ], 200);
    }

    public function store_freelancer_projects(StoreProjectRequest $request) {
        $role = $request->header('role');
        $user_id = $request->header('user_id');
        if(!$role && !$user_id) return response()->json(['status' => true, 'message' => 'Forbidden.'], 403);

        $user_id = session()->get('role') == 'freelancer' ? session()->get('id') : $request->user_id;

        $freelancer = Freelancer::where('user_id', $user_id)->firstOr(function() {
            return response()->json(['status' => false, 'message' => 'Freelancer Not Found'], 406);
        });

        $image_name = null;

        if($request->hasFile('project_image')) {
            $file = $request->file('project_image');
            $image_name = $file->getClientOriginalName();
            $save_file = $file->move(public_path().'/images/freelancer_projects', $image_name);
        }

        $save = FreelancerProject::create([
            'freelancer_id' => $freelancer->id,
            'project_name' => $request->project_name,
            'project_url' => $request->project_url,
            'project_image' => $image_name
        ]);

        return response()->json(['status' => true, 'message' => 'Project Added Successfully']);
    }

    public function fetch_freelancer_certificates(Request $request) {
        $role = $request->header('role');
        $user_id = $request->header('user_id');
        if(!$role && !$user_id) return response()->json(['status' => true, 'message' => 'Forbidden.'], 403);

        $freelancer = Freelancer::where('user_id', $user_id)->firstOr(function() {
            return response()->json(['status' => false, 'message' => 'Freelancer Not Found'], 406);
        });
        $freelancer_certificates = FreelancerCertificate::where('freelancer_id', $freelancer->id)->get();

        return response()->json([
            'freelancer_certificates' => $freelancer_certificates
        ], 200);
    }

    public function store_freelancer_certificates(StoreCertificateRequest $request) {
        $role = $request->header('role');
        $user_id = $request->header('user_id');
        if(!$role && !$user_id) return response()->json(['status' => true, 'message' => 'Forbidden.'], 403);

        $freelancer = Freelancer::where('user_id', $user_id)->firstOr(function() {
            return response()->json(['status' => false, 'message' => 'Freelancer Not Found'], 406);
        });

        $image_name = null;

        if($request->hasFile('certificate_image')) {
            $file = $request->file('certificate_image');
            $image_name = $file->getClientOriginalName();
            $save_file = $file->move(public_path().'/images/freelancer_certificates', $image_name);
        }

        $save = FreelancerCertificate::create([
            'freelancer_id' => $freelancer->id,
            'certificate' => $request->certificate,
            'certificate_date' => $request->certificate_date,
            'certificate_image' => $image_name
        ]);

        if($save) return response()->json(['status' => true, 'message' => 'Project Added Successfully']);
    }

    public function fetch_freelancer_experiences(Request $request) {
        $role = $request->header('role');
        $user_id = $request->header('user_id');
        if(!$role && !$user_id) return response()->json(['status' => true, 'message' => 'Forbidden.'], 403);

        $freelancer = Freelancer::where('user_id', $user_id)->firstOr(function() {
            return response()->json(['status' => false, 'message' => 'Freelancer Not Found'], 406);
        });

        $freelancer_experiences = FreelancerExperience::where('freelancer_id', $freelancer->id)->get();

        return response()->json([
            'freelancer_experiences' => $freelancer_experiences
        ], 200);
    }

    public function store_freelancer_experiences(StoreExperienceRequest $request) {
        $role = $request->header('role');
        $user_id = $request->header('user_id');
        if(!$role && !$user_id) return response()->json(['status' => true, 'message' => 'Forbidden.'], 403);

        $freelancer = Freelancer::where('user_id', $user_id)->firstOr(function() {
            return response()->json(['status' => false, 'message' => 'Freelancer Not Found'], 406);
        });

        $save = FreelancerExperience::create(array_merge($request->validated(), ['freelancer_id' => $freelancer->id]));
        if($save) return response()->json(['status' => true, 'message' => 'Experience Added Successfully']);
    }

    public function fetch_freelancer_educations(Request $request) {
        $role = $request->header('role');
        $user_id = $request->header('user_id');
        if(!$role && !$user_id) return response()->json(['status' => true, 'message' => 'Forbidden.'], 403);

        $freelancer = Freelancer::where('user_id', $user_id)->firstOr(function() {
            return response()->json(['status' => false, 'message' => 'Freelancer Not Found'], 406);
        });

        $freelancer_educations = FreelancerEducation::where('freelancer_id', $freelancer->id)->get();

        return response()->json([
            'freelancer_educations' => $freelancer_educations
        ], 200);
    }

    public function store_freelancer_educations(StoreEducationRequest $request) {
        $role = $request->header('role');
        $user_id = $request->header('user_id');
        if(!$role && !$user_id) return response()->json(['status' => true, 'message' => 'Forbidden'], 403);

        $freelancer = Freelancer::where('user_id', $user_id)->firstOr(function() {
            return response()->json(['status' => false, 'message' => 'Freelancer Not Found'], 406);
        });

        $save = FreelancerEducation::create(array_merge($request->validated(), ['freelancer_id' => $freelancer->id]));
        if($save) return response()->json(['status' => true, 'message' => 'Education Added Successfully']);

    }

}
