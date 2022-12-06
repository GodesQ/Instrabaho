<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


use App\Models\Freelancer;
use App\Models\FreelancerFollower;
use App\Models\Employer;
use App\Models\FreelancerCertificate;
use App\Models\FreelancerProject;
use App\Models\FreelancerExperience;
use App\Models\FreelancerEducation;
use App\Models\FreelancerSkill;
use App\Models\Skill;

use Yajra\DataTables\Facades\DataTables;

class FreelancerController extends Controller
{
    public function freelancer_role_form() {
        $id = session()->get('id');
        $freelancer_exists = Freelancer::where('user_id', $id)->exists();
        if($freelancer_exists) redirect()->route('freelancer.dasboard');
        return view('AllScreens.misc.freelancer-form', compact('id'));
    }

    public function save_freelancer_role_form(Request $request) {

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

        if($save) return redirect('/freelancer/dashboard')->with('success', 'Register as Worker Successfully');
    }

    public function dashboard() {
        $role = session()->get('role');
        $id = session()->get('id');
        $freelancer = Freelancer::where('user_id', $id)->with('package_checkout')->first();
        return view('UserAuthScreens.dashboards.freelancer', compact('freelancer'));
    }

    public function profile(Request $request) {
        $id = session()->get('id');
        $role = session()->get('role');
        $skills = Skill::all();
        $freelancer = Freelancer::where('user_id', $id)->with('user', 'certificates', 'experiences', 'educations')->first();
        return view('UserAuthScreens.user.freelancer.freelancer-profile', compact('freelancer', 'skills'));
    }

    public function update_profile(Request $request) {
        $request->validate([
            'gender' => 'required|in:Male,Female',
        ]);
        $data = $request->except('_token', 'id', 'username', 'email', 'firstname', 'lastname');
        $freelancer = Freelancer::where('user_id', $request->id)->first();
        $freelancer->update($data);
        $freelancer->user()->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => $request->username
        ]);
        return back()->with('success', 'Profile update successfully');
    }

    public function store_certificates(Request $request) {
        if(!isset($request->certificates)) return back()->with('fail', 'Add atleast one certificate.');
        if(count($request->certificates) < 0) return back()->with('fail', 'Add atleast one certificate.');

         $user_id = session()->get('role') == 'freelancer' ? session()->get('id') : $request->user_id;
        $freelancer = Freelancer::where('user_id', $user_id)->first();


        $certificates = FreelancerCertificate::where('freelancer_id', $freelancer->id)->get();

        if($certificates->count() > 0) {
            foreach ($certificates as $key => $certificate) {
                $image = public_path('/images/freelancer_certificates') . $certificate->certificate_image;
                $remove_image = @unlink($image);
            }
            FreelancerCertificate::where('freelancer_id', $freelancer->id)->delete();
        }

        foreach ($request->certificates as $key => $certifacate) {
            $image_name = $certifacate['old_image'];
            if(isset($certifacate['certificate_image'])) {
                // uploading image in public directory
                $file = $certifacate['certificate_image'];
                $image_name = $file->getClientOriginalName();
                $save_file = $file->move(public_path().'/images/freelancer_certificates', $image_name);
            }

            $save = FreelancerCertificate::create([
                'freelancer_id' => $freelancer->id,
                'certificate' => $certifacate['certificate'],
                'certificate_date' => $certifacate['certificate_date'],
                'certificate_image' => $image_name
            ]);
        }

        return back()->with('success', 'Certificates Added Successfully');
    }

    public function remove_certificate_image(Request $request) {

    }

    public function store_experiences(Request $request) {
        if(!isset($request->experiences)) return back()->with('fail', 'Add atleast one experiences.');

        $validation = $request->validate([
            'experiences.*.experience' => 'required',
            'experiences.*.company_name' => 'required',
            'experiences.*.start_date' => 'required',
            'experiences.*.description' => 'required|min:10',
        ]);


        $user_id = session()->get('role') == 'freelancer' ? session()->get('id') : $request->user_id;
        $freelancer = Freelancer::where('user_id', $user_id)->first();

        $past_experiences = FreelancerExperience::whereIn('freelancer_id', [$freelancer->id])->delete();
        foreach ($request->experiences as $key => $experience) {
            FreelancerExperience::create([
                'freelancer_id' => $freelancer->id,
                'experience_title' => $experience['experience'],
                'company_name' => $experience['company_name'],
                'start_date' => $experience['start_date'],
                'end_date' => $experience['end_date'],
                'description' => $experience['description']
            ]);
        }

        return back()->with('success', 'Experience update successfully.');
    }

    public function store_educations(Request $request) {
        if(!isset($request->educations)) return back()->with('fail', 'Add atleast one education.');

        $validation = $request->validate([
            'educations.*.education_title' => 'required',
            'educations.*.institute_name' => 'required',
            'educations.*.start_date' => 'required',
            'educations.*.description' => 'required|min:10',
        ]);

         $user_id = session()->get('role') == 'freelancer' ? session()->get('id') : $request->user_id;
        $freelancer = Freelancer::where('user_id', $user_id)->first();

        $past_educations = FreelancerEducation::whereIn('freelancer_id', [$freelancer->id])->delete();

        foreach ($request->educations as $key => $education) {
            FreelancerEducation::create([
                'freelancer_id' => $freelancer->id,
                'education_title' => $education['education_title'],
                'institute_name' => $education['institute_name'],
                'start_date' => $education['start_date'],
                'end_date' => $education['end_date'],
                'description' => $education['description']
            ]);
        }
        return back()->with('success', 'Education update successfully.');
    }

    public function store_skills(Request $request) {
        if(!isset($request->skills)) return back()->with('fail', 'Add atleast one skills.');
        $validation = $request->validate([
            'skills.*.skill' => 'required',
            'skills.*.skill_percentage' => 'required',
        ]);
        $user_id = session()->get('role') == 'freelancer' ? session()->get('id') : $request->user_id;
        $freelancer = Freelancer::where('user_id', $user_id)->first();
        $past_skills = FreelancerSkill::whereIn('freelancer_id', [$freelancer->id])->delete();

        foreach ($request->skills as $key => $skill) {
            $create = FreelancerSkill::create([
                'freelancer_id' => $freelancer->id,
                'skill_id' => $skill['skill'],
                'skill_percentage' =>$skill['skill_percentage']
            ]);
        }

        return back()->with('success', 'Skill update successfully');
    }

    public function index(Request $request) {
        return view('AdminScreens.freelancers.freelancers');
    }

    public function data_table(Request $request) {
        abort_if(!$request->ajax(), 404);
        $data = Freelancer::select('*')->with('user')->latest('id');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('freelancer', function($row){
                if($row->user->profile_image) {
                    return $div = '<img class="avatar avatar-sm" src="../../../images/user/profile/' . $row->user->profile_image . '" />
                    '. $row->display_name .'';
                }

                return $div = '<img class="avatar avatar-sm" src="../../../images/user-profile.png" />
                    '. $row->display_name .'';
            })
            ->addColumn('member_since', function($row) {
                return date_format($row->created_at, "F d, Y");
            })
            ->addColumn('active_status', function($row) {
                if($row->is_active) {
                    return '<div class="badge badge-success"><i class="fa fa-circle text-success"><i> <span class="text-success mx-50">Active</span></div>';
                }
                return '<div class="badge badge-warning d-flex align-items-center justify-content-center p-50" style="font-size: 10px; !important; width: 100px;"><span class="mx-50" style="font-size: 10px; !important">Inactive</span></div>';
            })
            ->addColumn('action', function($row){
                $btn = '<a href="/admin/freelancers/edit/'. $row->id .'" class="edit datatable-btn datatable-btn-edit"><i class="fa fa-edit"></i></a>
                        <a href="javascript:void(0)" class="edit datatable-btn datatable-btn-remove"><i class="fa fa-trash"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'freelancer', 'member_since', 'active_status'])
            ->toJson();
    }

    public function edit(Request $request) {
        $freelancer = Freelancer::where('id', $request->id)->with('user')->first();
        $skills = Skill::all();
        return view('AdminScreens.freelancers.edit-freelancer', compact('freelancer', 'skills'));
    }

    public function update(Request $request) {

        $request->validate([
            'id' => 'required',
            'username' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'display_name' => 'required',
            'tagline' => 'required',
            'freelancer_type' => 'required|in:Individual,Group,Student',
            'hourly_rate' => 'required|numeric',
            'gender' => 'required|in:Male,Female',
            'contactno' => 'required',
            'description' => 'required',
            'address' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $freelancer = Freelancer::where('id', $request->id)->first();

        $update_user = $freelancer->user()->update([
            'username' => $request->username,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'middlename' => $request->middlename
        ]);

        $freelancer_inputs = $request->except('id', 'username', 'lastname', 'middlename', 'firstname', 'email', '_token');
        $update_freelancer = $freelancer->update($freelancer_inputs);

        return back()->with('success', 'Data Information Update Successfully');
    }

    public function search(Request $request) {
        abort_if(!$request->ajax(), 403);
        $query = $request->input('search');

        if($request->type == 'display_name') {
            $freelancers = Freelancer::where('display_name', 'like', '%'.$query.'%')->get();
        }

        if($request->type == 'full_name') {
            $freelancers = Freelancer::with('user')->whereHas('user', function($q) use ($query) {
                $q->where(DB::raw("concat(firstname, ' ', lastname)"), 'LIKE', "%".$query."%");
            })->get();
        }


        $freelancers_collection = $freelancers->toArray();
            $results = [];
            foreach ($freelancers_collection as $key => $freelancer) {
               $result = [
                    'id' => $freelancer['id'],
                    'text' => $request->type == 'display_name' ? $freelancer['display_name'] :  $freelancer['user']['firstname'] . " " . $freelancer['user']['lastname']
               ];
               array_push($results, $result);
            }
            return response()->json($results);
    }
}
