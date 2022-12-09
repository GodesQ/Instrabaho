<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Employer;
use App\Models\Freelancer;
use App\Models\FreelancerFollower;

use Yajra\DataTables\Facades\DataTables;
use DB;

class FollowFreelancerController extends Controller
{
    public function follow_freelancer(Request $request) {
        $freelancer_id = $request->freelancer_id;

        $employer = Employer::where('user_id', session()->get('id'))->first();
        if(!$employer) return back()->with('fail', "User doesn't exist.");

        $freelancer = Freelancer::where('id', $freelancer_id)->first();
        if(!$freelancer) return back()->with('fail', "Freelancer doesn't exist.");

        $followExist = FreelancerFollower::where('freelancer_id', $freelancer_id)->where('follower_id', $employer->id)->first();
        if($followExist) {
            $followExist->delete();
            return back()->with('success', 'Unfollow Successfully');
        }

        $follow = FreelancerFollower::create([
            'freelancer_id' => $freelancer_id,
            'follower_id' => $employer->id,
        ]);

        if($follow) return back()->with('success', 'Follow Freelancer Successfully');

        return back()->with('fail', 'Something went wrong.');
    }

    public function followed_freelancer() {
        $employer = Employer::where('user_id', session()->get('id'))->first();
        $followed_freelancers =  FreelancerFollower::where('follower_id', $employer->id)->with('freelancer')->cursorPaginate(10);
        return view('UserAuthScreens.followed_freelancers.followed_freelancers', compact('followed_freelancers'));
    }

    public function admin_index() {
        return view('AdminScreens.freelancers_followers.freelancers_followers');
    }

    public function data_table(Request $request) {
        abort_if(!$request->ajax(), 404);

        $data = FreelancerFollower::select('freelancer_id', DB::raw('MAX(follower_id) as follower_id'), DB::raw('MAX(created_at) as created_at'))
        ->groupBy('freelancer_id')
        ->latest('created_at')
        ->with('freelancer', 'followers');

        return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('freelancer', function($row) {
                    return $row->freelancer->display_name;
                })
                ->addColumn('tagline', function($row) {
                    return $row->freelancer->tagline;
                })
                ->addColumn('total_followers', function($row) {
                    return $row->followers->count();
                })
                ->toJson(true);

    }
}
