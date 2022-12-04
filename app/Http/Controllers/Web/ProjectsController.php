<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ServiceCategory;
use App\Models\Skill;
use App\Models\Project;
use App\Models\ProjectProposal;
use App\Models\Employer;
use App\Models\EmployerPackage;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;

use Carbon\Carbon;

use Yajra\DataTables\Facades\DataTables;

class ProjectsController extends Controller
{
    public function index() {
        $user_id = session()->get('id');
        $employer = Employer::where('user_id', $user_id)->first();
        $projects = Project::where('employer_id', $employer->id)->where('expiration_date', '>=' , Carbon::now())->latest('id')->cursorPaginate(10);
        return view('UserAuthScreens.projects.projects', compact('projects'));
    }

    public function employer_ongoing(Request $request) {
        $employer = Employer::where('user_id', session()->get('id'))->first();
        $proposals = ProjectProposal::where('employer_id', $employer->id)->where('status', 'approved')->with('project', 'contract')->whereHas('project', function($query) {
            $query->where('expiration_date', '>', Carbon::now())->orWhere('isExpired', 0);
        })->get();
        return view('UserAuthScreens.projects.employer.ongoing.ongoing', compact('proposals'));
    }

    public function create() {
        $categories = ServiceCategory::all();
        $skills = Skill::all();
        return view('UserAuthScreens.projects.create-project', compact('categories', 'skills'));
    }

    public function store(StoreProjectRequest $request) {
        //check if the current plan is exceed in limit
        if($this->checkAvailableProject($request->project_type)) return back()->with('fail', 'Sorry but your current plan exceed the limit. Wait for expiration then buy again');

        $images = array();
        foreach ($request->file('attachments') as $key => $attachment) {
            $image_name = $attachment->getClientOriginalName();
            $save_file = $attachment->move(public_path().'/images/projects', $image_name);
            array_push($images, $image_name);
        }

        $json_images = json_encode($images);
        $user_id = session()->get('id');

        $employer = Employer::where('user_id', $user_id)->first();

        $create = Project::create(array_merge($request->validated(), [
            'employer_id' => $employer->id,
            'attachments' => $json_images,
            'skills' => json_encode($request->skills),
            'expiration_date' => $employer->package_date_expiration > Carbon::now() || $employer->package_date_expiration ? $employer->package_date_expiration : Carbon::now()
        ]));

        if($create) return redirect()->route('freelancer.projects.index')->with('success', 'Project Created Successfully');
    }

    public function user_edit(Request $request) {
        $project = Project::where('id', $request->id)->firstOrFail();
        $categories = ServiceCategory::all();
        $skills = Skill::all();
        $project_images = json_decode($project->attachments);
        return view('UserAuthScreens.projects.edit-project', compact('project', 'categories', 'skills', 'project_images'));
    }

    public function update(Request $request) {
        $request->validate([
            'id' => 'required|exists:projects,id',
            'employer' => 'required',
            'title' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'project_level' => 'required',
            'project_cost_type' => 'required',
            'cost' => 'required|numeric',
            'project_duration' => 'required|in:1-3 Weeks,1-5 Days,Long Term,Short Term,1-2 Months',
            'freelancer_type' => 'required|in:Company,Group,Individual,Student',
            'english_level' => 'required|in:Basic,Bilingual,Fluent,Professional',
            'location' => 'required',
            'project_type' => 'required|in:simple,featured',
            'skills' => 'required'
        ]);

        $project = Project::where('id', $request->id)->first();
        $project_images = json_decode($project->attachments);

        if($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $key => $attachment) {
                $image_name = $attachment->getClientOriginalName();
                $save_file = $attachment->move(public_path().'/images/projects', $image_name);
                array_push($project_images, $image_name);
            }
        }

        $json_images = json_encode($project_images);

        $update = Project::where('id', $request->id)->update([
            'employer_id' => $request->employer,
            'title' => $request->title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'attachments' => $json_images,
            'project_level' => $request->project_level,
            'project_cost_type' => $request->project_cost_type,
            'cost' => $request->cost,
            'project_duration' => $request->project_duration,
            'freelancer_type' => $request->freelancer_type,
            'english_level' => $request->english_level,
            'skills' => json_encode($request->skills),
            'location' => $request->location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'project_type' => $request->project_type,
        ]);

        if($update) {
            return back()->with('success', 'Update Successfully');
        }
    }

    public function remove_project_image(Request $request) {
        $key_id = $request->key_id;
        $project = Project::where('id', $request->id)->first();
        $project_images = json_decode($project->attachments);

        if(count($project_images) < 2) return response()->json(['status' => 424, 'message' => 'Fail! You only have one image. Keep this image for reference']);

        // Search image in array
        $found_image = array_search($project_images[$key_id], $project_images);

        if($found_image) {
            $image_path = public_path('/images/projects/') . $project_images[$key_id];
            $remove_image = @unlink($image_path);
            unset($project_images[$key_id]);
        }

        $project->attachments = json_encode($project_images);
        $save = $project->save();

        if($save) {
            return response()->json([
                'status' => 201,
                'message' => 'Remove Successfully'
            ]);
        }
    }

    public function destroy(Request $request) {
        $project = Project::where('id', $request->id)->first();
        $project_images = json_decode($project->attachments);

        foreach ($project_images as $key => $image) {
            $image_path = public_path('/images/projects/') . $image;
            $remove_image = @unlink($image_path);
        }

        $delete = $project->delete();

        if($delete) {
            return response()->json([
                'status' => 201,
                'message' => 'Delete Successfully'
            ]);
        }
    }

    private function checkAvailableProject($type) {

        // get the data of user
        $user = Employer::where('user_id', session()->get('id'))->with('package_checkout', 'user')->first();

        // Get the current purchased plan of user
        $purchased_plan = EmployerPackage::where('id', $user->package_checkout->package_type)->first();

        // Get the current created projects of user
        $current_user_projects = Project::where('employer_id', $user->id)->where('expiration_date', $user->package_date_expiration)->count();
        $current_user_featured_projects = Project::where('employer_id', $user->id)->where('expiration_date', $user->package_date_expiration)->where('project_type', 'featured')->count();

        if($current_user_projects == $purchased_plan->total_projects) return true;

        if($type == 'featured') {
            if($current_user_featured_projects == $purchased_plan->total_feature_projects) return true;
        }

        return false;
    }

    public function admin_index() {
        return view("AdminScreens.projects.projects");
    }

    public function data_table(Request $request) {
        abort_if(!$request->ajax(), 403);
        $data = Project::select('*')->with('employer', 'category')->where('expiration_date', '>=', Carbon::now());
        return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('category', function($row) {
                    return $row->category->name;
                })
                ->addColumn('type', function($row) {
                    if($row->project_type == 'featured') {
                        return '<div class="badge badge-success">'.$row->project_type.'</div>';
                    }
                    return '<div class="badge badge-secondary">'.$row->project_type.'</div>';
                })
                ->addColumn('employer', function($row) {
                    return $row->employer->user->firstname . " " . $row->employer->user->lastname;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="/admin/projects/edit/'. $row->id .'" class="edit datatable-btn datatable-btn-edit"><i class="fa fa-edit"></i></a>
                            <a href="javascript:void(0)" class="edit datatable-btn datatable-btn-remove"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'type'])
                ->toJson();
    }

    public function admin_edit(Request $request) {
        $project = Project::where('id', $request->id)->with('employer')->firstOrFail();
        $categories = ServiceCategory::all();
        $skills = Skill::all();
        $project_images = json_decode($project->attachments);
        return view('AdminScreens.projects.edit-project', compact('project', 'categories', 'skills', 'project_images'));
    }

    public function admin_create() {
        $categories = ServiceCategory::all();
        $skills = Skill::all();
        return view('AdminScreens.projects.create-project', compact('categories', 'skills'));
    }
}
