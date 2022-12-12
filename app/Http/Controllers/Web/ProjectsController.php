<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ServiceCategory;
use App\Models\Skill;
use App\Models\Project;
use App\Models\ProjectProposal;
use App\Models\Employer;
use App\Models\Freelancer;
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
        $projects = Project::where('employer_id', $employer->id)->cursorPaginate(10);
        return view('UserAuthScreens.projects.projects', compact('projects'));
    }

    public function employer_ongoing(Request $request) {
        $employer = Employer::where('user_id', session()->get('id'))->first();
        $proposals = ProjectProposal::where('employer_id', $employer->id)->where('status', 'approved')->with('project', 'contract')->get();
        return view('UserAuthScreens.projects.employer.ongoing.ongoing', compact('proposals'));
    }

    public function employer_completed(Request $request) {
        $employer = Employer::where('user_id', session()->get('id'))->first();
        $proposals = ProjectProposal::where('employer_id', $employer->id)->where('status', 'completed')->with('project', 'contract')->get();

        return view('UserAuthScreens.projects.employer.completed.completed', compact('proposals'));
    }

    public function freelancer_ongoing(Request $request) {
        $freelancer = Freelancer::where('user_id', session()->get('id'))->first();
        $proposals = ProjectProposal::where('freelancer_id', $freelancer->id)->where('status', 'approved')->with('project', 'contract')->get();
        return view('UserAuthScreens.projects.freelancer.ongoing.ongoing', compact('proposals'));
    }

    public function freelancer_completed(Request $request) {
        $freelancer = Freelancer::where('user_id', session()->get('id'))->first();
        $proposals = ProjectProposal::where('freelancer_id', $freelancer->id)->where('status', 'completed')->with('project', 'contract')->get();

        return view('UserAuthScreens.projects.freelancer.completed.completed', compact('proposals'));
    }

    public function create() {
        $categories = ServiceCategory::all();
        $skills = Skill::toBase()->get();
        $employer = Employer::where('user_id', auth('user')->user()->id)->first();
        return view('UserAuthScreens.projects.create-project', compact('categories', 'skills', 'employer'));
    }

    public function store(StoreProjectRequest $request) {
        // dd($request->all());

        $images = array();
        foreach ($request->file('attachments') as $key => $attachment) {
            $image_name = $attachment->getClientOriginalName();
            $save_file = $attachment->move(public_path().'/images/projects', $image_name);
            array_push($images, $image_name);
        }

        $json_images = json_encode($images);
        $user_id = session()->get('id');

        $employer = Employer::where('user_id', $user_id)->first();

        #compute total cost
        $system_deduction = intval($request->cost) * 0.10;
        $total_cost = intval($request->cost) - $system_deduction;

        $create = Project::create(array_merge($request->validated(), [
            'employer_id' => $employer->id,
            'attachments' => $json_images,
            'skills' => json_encode($request->skills),
            'start_date' => date_format($request->start_date, 'Y-m-d'),
            'end_date' => date_format($request->end_date, 'Y-m-d'),
            'datetime' => $request->datetime,
            'total_cost' => $total_cost,
        ]));

        if($create) return redirect()->route('employer.projects.index')->with('success', 'Project Created Successfully');
    }

    public function user_edit(Request $request) {
        $project = Project::where('id', $request->id)->firstOrFail();
        $categories = ServiceCategory::all();
        $skills = Skill::all();
        $project_images = json_decode($project->attachments);
        return view('UserAuthScreens.projects.edit-project', compact('project', 'categories', 'skills', 'project_images'));
    }

    public function update(UpdateProjectRequest $request) {

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

    public function selected_dates(Request $request) {
        abort_if(!$request->ajax(), 404);
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
                ->addColumn('status', function($row) {
                    if($row->status == 'approved' || $row->status == 'completed') {
                        return '<div class="badge badge-success">'.$row->status.'</div>';
                    } else {
                        return '<div class="badge badge-primary">'.$row->status.'</div>';
                    }
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="/admin/projects/edit/'. $row->id .'" class="edit datatable-btn datatable-btn-edit"><i class="fa fa-edit"></i></a>
                            <a href="javascript:void(0)" class="edit datatable-btn datatable-btn-remove"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'type', 'status'])
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
