<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Freelancer;
use App\Models\FreelancerFollower;
use App\Models\Employer;

class FreelancerController extends Controller
{
    public function freelancer_role_form() {
        $id = session()->get('id');
        return view('AllScreens.misc.freelancer-form', compact('id'));
    }

    public function save_freelancer_role_form(Request $request) {
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
        ]);
        
        if($save) return redirect('/');
    }

    public function view_profile(Request $request) {
        $employer = Employer::where('user_id', session()->get('id'))->first();
        $freelancer = Freelancer::where('user_id', $request->id)->with('user', 'certificates', 'experiences', 'educations', 'services', 'skills')->first(); 
        $active_services = $freelancer->services()->where('expiration_date', '>', Carbon::now())->get();
        $featured_services = $freelancer->services()->where('type', 'featured')->where('expiration_date', '>', Carbon::now())->get();
        $follow_freelancer = false;
        //if the user has an account of employer
        if($employer){
            $follow_freelancer = FreelancerFollower::where('freelancer_id', $freelancer->id)->where('follower_id', $employer->id)->exists();
        }
        return view('UserAuthScreens.user.freelancer.view-freelancer', compact('freelancer', 'featured_services', 'active_services', 'follow_freelancer'));
    }
}