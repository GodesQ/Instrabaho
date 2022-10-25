<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Freelancer;
use App\Models\Employer;
use App\Models\EmployerFollower;

class FollowEmployerController extends Controller
{
    public function follow_employer(Request $request) {
        $employer_id = $request->employer_id;
        
        $freelancer = Freelancer::where('user_id', session()->get('id'))->first();
        if(!$freelancer) return back()->with('fail', "User doesn't exist.");

        $employer = Employer::where('id', $employer_id)->first();
        if(!$freelancer) return back()->with('fail', "Employer doesn't exist.");

        $followExist = EmployerFollower::where('employer_id', $employer_id)->where('follower_id', $freelancer->id)->first();
        if($followExist) {
            $followExist->delete();
            return back()->with('success', 'Unfollow Successfully');
        }
        
        $follow = EmployerFollower::create([
            'employer_id' => $employer_id,
            'follower_id' => $freelancer->id,
        ]);

        if($follow) return back()->with('success', 'Follow Freelancer Successfully');

        return back()->with('fail', 'Something went wrong.');
    }

    public function followed_employer() {
        $freelancer = Freelancer::where('user_id', session()->get('id'))->first();
        $followed_employers =  EmployerFollower::where('follower_id', $freelancer->id)->with('employer')->cursorPaginate(10);
        return view('UserAuthScreens.followed_employers.followed_employers', compact('followed_employers'));
    }
}