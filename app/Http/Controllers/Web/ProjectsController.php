<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ServiceCategory;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Employer;
use App\Models\EmployerPackage;
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

    public function create() {
        $categories = ServiceCategory::all();
        $skills = Skill::all();
        return view('UserAuthScreens.projects.create-project', compact('categories', 'skills'));
    }

    public function store(Request $request) {
        //check if the current plan is exceed in limit
        if($this->checkAvailableProject($request->project_type)) return back()->with('fail', 'Sorry but your current plan exceed the limit. Wait for expiration then buy again');
        
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'project_level' => 'required',
            'project_cost_type' => 'required',
            'cost' => 'required',
            'project_duration' => 'required',
            'freelancer_type' => 'required',
            'english_level' => 'required',
            'location' => 'required',
            'project_type' => 'required',
        ]);
        
        $images = array();
        foreach ($request->file('attachments') as $key => $attachment) {
            $image_name = $attachment->getClientOriginalName();
            $save_file = $attachment->move(public_path().'/images/projects', $image_name);
            array_push($images, $image_name);
        }

        $json_images = json_encode($images);
        $user_id = session()->get('id');
        $employer = Employer::where('user_id', $user_id)->first();
        
        $create = Project::create([
            'employer_id' => $employer->id,
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
            'expiration_date' => $employer->package_date_expiration,
        ]);

        if($create) {
            return redirect('/projects')->with('success', 'Project Created Successfully');
        }
    }

    public function edit(Request $request) {
        $project = Project::where('id', $request->id)->first();
        $categories = ServiceCategory::all();
        $skills = Skill::all();
        $project_images = json_decode($project->attachments);
        return view('UserAuthScreens.projects.edit-project', compact('project', 'categories', 'skills', 'project_images'));
    }

    public function update(Request $request) {

        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'project_level' => 'required',
            'project_cost_type' => 'required',
            'cost' => 'required',
            'project_duration' => 'required',
            'freelancer_type' => 'required',
            'english_level' => 'required',
            'location' => 'required',
            'project_type' => 'required',
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
        dd($request->all());
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
        $data = Project::select('*')->with('employer', 'category');
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
                    $btn = '<a href="/admin/employer_packages/edit/'. $row->id .'" class="edit btn btn-primary"><i class="fa fa-edit"></i></a>
                            <a href="javascript:void(0)" class="edit btn btn-danger"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'type'])
                ->toJson();
    }
}