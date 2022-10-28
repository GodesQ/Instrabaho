<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Employer;
use App\Models\Project;
use App\Models\Freelancer;
use App\Models\EmployerFollower;

use Yajra\DataTables\Facades\DataTables;

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

    public function index() {
        return view('AdminScreens.employers.employers');
    }

    public function data_table(Request $request) {
        if($request->ajax()) {
            $data = Employer::select('*')->with('user')->latest('id');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('employer', function($row){
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
                    $btn = '<a href="/admin/employer_packages/edit/'. $row->id .'" class="edit btn btn-primary"><i class="fa fa-edit"></i></a>
                            <a href="javascript:void(0)" class="edit btn btn-danger"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'employer', 'member_since'])
                ->toJson();
        }
    }
}