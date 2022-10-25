<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Employer;
use App\Models\Project;
use App\Models\Freelancer;
use App\Models\EmployerFollower;

class EmployerController extends Controller
{
    public function employer_role_form() {
        $id = session()->get('id');
        return view('AllScreens.misc.employer-form', compact('id'));
    }

    public function save_employer_role_form(Request $request) {
        $id = session()->get('id');
        $save = Employer::create([
            'user_id' => $id,
            'display_name' => $request->display_name,
            'number_employees' => $request->number_employees,
            'contactno' => $request->contactno,
            'tagline' => $request->tagline,
            'description' => $request->description,
            'address' => $request->address,
        ]);
        return redirect('/');
    }

    public function view_profile(Request $request) {
        $freelancer = Freelancer::where('user_id', session()->get('id'))->first();
        $employer = Employer::where('user_id', $request->id)->with('user', 'projects')->first();
        $featured_projects = Project::where('employer_id', $employer->id)->where('project_type', 'featured')->get();
        $follow_employer = false;
        if($freelancer) {
            $follow_employer = EmployerFollower::where('employer_id', $employer->id)->where('follower_id', $freelancer->id)->exists();
        }
        return view('UserAuthScreens.user.employer.view-employer', compact('employer', 'featured_projects', 'follow_employer'));
    }
}