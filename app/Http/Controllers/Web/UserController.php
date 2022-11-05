<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Freelancer;
use App\Models\FreelancePackage;
use App\Models\Employer;
use App\Models\User;
use App\Models\PackageCheckout;
use App\Models\FreelancerCertificate;
use App\Models\FreelancerProject;
use App\Models\FreelancerExperience;
use App\Models\FreelancerEducation;
use App\Models\FreelancerSkill;
use App\Models\Skill;

class UserController extends Controller
{

    public function dashboard() {
        $role = session()->get('role');
        $id = session()->get('id');
        $freelancer = Freelancer::where('user_id', $id)->with('package_checkout')->first();
        $employer = Employer::where('user_id', $id)->with('package_checkout')->first();

        if($this->checkAccountIfExist($freelancer, $employer)) return $this->checkAccountIfExist($freelancer, $employer);
        if($role == 'freelancer')  return view('UserAuthScreens.dashboards.freelancer', compact('freelancer'));
        return view('UserAuthScreens.dashboards.employer', compact('employer'));
    }

    public function user_image_form(Request $request) {
        $id = session()->get('id');
        $user = User::where('id', $id)->first();
        return view('AllScreens.misc.user-image-form', compact('user'));
    }

    public function checkAccountIfExist($freelancer, $employer) {
        $role = session()->get('role');
        $id = session()->get('id');
        if($role == 'freelancer' && !$freelancer) return redirect('freelancer_role_form')->with('fail', 'You need to fill up this form to continue in dashboard. Thankyou');
        if($role == 'employer' && !$employer) return redirect('employer_role_form')->with('fail', 'You need to fill up this form to continue in dashboard. Thankyou');;

        return false;
    }

    public function profile(Request $request) {
        $id = session()->get('id');
        $role = session()->get('role');
        if($role == 'freelancer') {
            $skills = Skill::all();
            $freelancer = Freelancer::where('user_id', $id)->with('user', 'certificates', 'experiences', 'educations')->first();
            return view('UserAuthScreens.user.freelancer.freelancer-profile', compact('freelancer', 'skills'));
        } else {
            $employer = Employer::where('user_id', $id)->with('user')->first();
            return view('UserAuthScreens.user.employer.employer-profile', compact('employer'));
        }
    }

    public function update_profile(Request $request) {
        $request->validate([
            'gender' => 'required|in:Male,Female',
        ]);
        $data = $request->except('_token', 'id', 'username', 'email', 'firstname', 'lastname');
        $user_model = session()->get('role') == 'freelancer' ? Freelancer::class : Employer::class;
        $save = $user_model::where('user_id', $request->id)->update($data);
        return back()->with('success', 'Profile update successfully');
    }


    public function change_user_picture(Request $request) {
        $profile = User::where('id', $request->id)->first();
        $profile_image = $request->old_profile_picture;
        $cover_image = $request->old_cover_picture;

        if(isset($request->new_profile_picture)) {
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

        if($save) return back()->with('success', 'Image Successfully Updated');
    }

    public function user_change_password(Request $request) {
        $user = User::where('id', $request->id)->first();
        if(!Hash::check($request->old_password, $user->password)) return back()->with('fail', "Sorry your old password is incorrect.");
        if($request->confirm_password != $request->new_password) return back()->with('fail', "Sorry your password didn't match to confirm password.");

        $user->password = Hash::make($request->new_password);
        $save = $user->save();

        if($save) {
            return back()->with('success', 'Password Change Successfully');
        }
    }

    public function change_user_payment_method(Request $request) {
        $request->validate([
            'payment_method' => 'required'
        ]);


    }
}
