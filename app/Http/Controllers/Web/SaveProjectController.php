<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SaveProject;
use App\Models\Project;
use App\Models\Employer;
use App\Models\Freelancer;

class SaveProjectController extends Controller
{
    public function save_project(Request $request) {
        $owner_id = $request->owner_id;
        $project_id = $request->id;

        //check first, if the follower has an account of freelancer before following project
        $user_id = session()->get('id');
        $freelancerExist = Freelancer::where('user_id', $user_id)->first();
        if(!$freelancerExist) return back()->with('fail', 'You need to create a freelancer account before following projects');

        //check if the owner_id exist in employer_table 
        $owner = Employer::find($owner_id);
        if(!$owner) return back()->with('fail', "Oops! This Employer doesn't exist.");

        //check if the project and owner exist
        $project = Project::where('id', $project_id)->where('employer_id', $owner_id)->first();
        if(!$project) return back()->with('fail', "This Project or Employer doesn't exist.");

        // check if the user already save the project
        $saved_project_exist = SaveProject::where('project_id', $project_id)->where('follower_id', $freelancerExist->id)->exists();
        if($saved_project_exist) return back()->with('fail', 'You are already follow this project');
        
        $create = SaveProject::create([
            'project_id' => $project_id,
            'owner_id' => $owner_id,
            'follower_id' => $freelancerExist->id,
        ]);

        if($create) {
            return back()->with('success', 'Follow Successfully');
        }
        return back()->with('fail', 'Fail! Something went wrong');
    }

    public function freelancer_saved_projects() {
        $freelancer = Freelancer::where('user_id', session()->get('id'))->first();
        $saved_projects = SaveProject::where('follower_id', $freelancer->id)->with('project')->cursorPaginate(10);
        return view('UserAuthScreens.saved_projects.saved_projects', compact('saved_projects'));
    }

    public function destroy(Request $request) {
        $delete = SaveProject::where('id', $request->id)->delete();
        if($delete) return back()->with('success', 'Unsaved Project Successfully');
    }
}