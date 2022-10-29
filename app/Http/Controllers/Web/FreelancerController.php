<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Freelancer;
use App\Models\FreelancerFollower;
use App\Models\Employer;

use Yajra\DataTables\Facades\DataTables;

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
            ->addColumn('action', function($row){     
                $btn = '<a href="/admin/freelancers/edit/'. $row->id .'" class="edit btn btn-primary"><i class="fa fa-edit"></i></a>
                        <a href="javascript:void(0)" class="edit btn btn-danger"><i class="fa fa-trash"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'freelancer', 'member_since'])
            ->toJson();
    }

    public function edit(Request $request) {
        $freelancer = Freelancer::where('id', $request->id)->with('user')->first();
        return view('AdminScreens.freelancers.edit-freelancer', compact('freelancer'));
    }
}