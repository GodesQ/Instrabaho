<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Employer;
use App\Models\Project;
use App\Models\Freelancer;
use App\Models\User;
use App\Models\EmployerFollower;
use App\Models\ProjectContract;
use App\Http\Requests\EmployerRegisterForm\RegisterEmployerRequest;
use DB;

use Yajra\DataTables\Facades\DataTables;

class EmployerController extends Controller
{
    public function role_form() {
        $id = session()->get('id');
        $user = User::where('id', $id)->first();
        return view('AllScreens.misc.employer-form', compact('id', 'user'));
    }

    public function save_role_form(RegisterEmployerRequest $request) {
        $id = session()->get('id');
        $save = Employer::create(array_merge($request->validated(), [
            'user_id' => $id,
        ]));

        return redirect()->route('employer.dashboard')->with('success', 'Employer Account Successfully Created.');
    }

    public function dashboard() {
        $role = session()->get('role');
        $id = session()->get('id');
        $employer = Employer::where('user_id', $id)->firstOrFail();
        $ongoing_projects = Project::where('status', 'approved')->where('employer_id', $employer->id)->latest('id')->get();
        $completed_projects = Project::where('status', 'completed')->where('employer_id', $employer->id)->latest('id')->get();
        return view('UserAuthScreens.dashboards.employer', compact('employer', 'ongoing_projects', 'completed_projects'));
    }

    public function profile(Request $request) {
        $id = session()->get('id');
        $role = session()->get('role');
        $employer = Employer::where('user_id', $id)->with('user')->first();
        return view('UserAuthScreens.user.employer.employer-profile', compact('employer'));
    }

    public function update_profile(Request $request) {
        $data = $request->except('_token', 'id', 'username', 'email', 'firstname', 'lastname');
        $employer = Employer::where('user_id', $request->id)->first();
        $employer->update($data);

        $employer->user()->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => $request->username
        ]);

        return back()->with('success', 'Profile update successfully');
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
                    $btn = '<a href="/admin/employers/edit/'. $row->id .'" class="edit datatable-btn datatable-btn-edit"><i class="fa fa-edit"></i></a>
                            <a href="javascript:void(0)" class="edit datatable-btn datatable-btn-remove"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'employer', 'member_since'])
                ->toJson();
        }
    }

    public function edit(Request $request) {
        $employer = Employer::where('id', $request->id)->with('user')->first();
        return view('AdminScreens.employers.edit-employer', compact('employer'));
    }

    public function update(Request $request) {
        $request->validate([
            'id' => 'required',
            'username' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'display_name' => 'required',
            'tagline' => 'required',
            'number_employees' => 'required|in:0,1-10,11-20,21-30,31-50',
            'contactno' => 'required',
            'description' => 'required',
            'address' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $employer = Employer::where('id', $request->id)->first();

        $update_user = $employer->user()->update([
            'username' => $request->username,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'middlename' => $request->middlename
        ]);

        $employer_inputs = $request->except('id', 'username', 'lastname', 'middlename', 'firstname', 'email', '_token');
        $update_employer = $employer->update($employer_inputs);

        return back()->with('success', 'Data Information Update Successfully');
    }

    public function search(Request $request) {
        abort_if(!$request->ajax(), 403);
        $query = $request->input('search');

        if($request->type == 'display_name') {
            $employers = Employer::where('display_name', 'like', '%'.$query.'%')->get();
        }

        if($request->type == 'full_name') {
            $employers = Employer::with('user')->whereHas('user', function($q) use ($query) {
                $q->where(DB::raw("concat(firstname, ' ', lastname)"), 'LIKE', "%".$query."%");
            })->get();
        }


        $employers_collection = $employers->toArray();
            $results = [];
            foreach ($employers_collection as $key => $employer) {
               $result = [
                    'id' => $employer['id'],
                    'text' => $request->type == 'display_name' ? $employer['display_name'] :  $employer['user']['firstname'] . " " . $employer['user']['lastname']
               ];
               array_push($results, $result);
            }
            return response()->json($results);
    }
}
