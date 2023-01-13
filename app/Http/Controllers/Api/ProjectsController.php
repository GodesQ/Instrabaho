<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

use App\Models\Project;
use App\Models\ServiceCategory;
use App\Models\Skill;
use App\Models\ProjectProposal;
use App\Models\ProjectOffer;
use App\Models\Employer;
use App\Models\Freelancer;
use App\Models\EmployerPackage;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;

class ProjectsController extends Controller
{
    public function projects() {
        $projects = Project::with('employer')->latest('id')->get();
        return response($projects, 200);
    }

    public function fetch_projects(Request $request) {
        $title = $request->input('title');
        $categories = $request->input('categories') ? json_decode($request->input('categories')) : [];
        $my_range = $request->input('my_range');
        $max_range = $request->input('max_range');
        $min_range = $request->input('min_range');
        $address = $request->input('address');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $type = $request->input('type');
        $radius = $request->input('radius') ? $request->input('radius') : 10;
        $result = $request->input('result') ? $request->input('result') : 5;

        $projects = Project::select('*')->when($title, function($q) use ($title) {
            return $q->where(DB::raw('lower(title)'), 'like', '%' . strtolower($title) . '%');
        })
        ->when($categories, function ($q) use ($categories) {
            if($categories[0]) return $q->whereIn('category_id', $categories);
        })
        ->when($latitude and $longitude, function ($q) use ($latitude, $longitude, $radius) {
            return $q->addSelect(DB::raw("6371 * acos(cos(radians(" . $latitude . "))
            * cos(radians(projects.latitude))
            * cos(radians(projects.longitude) - radians(" . $longitude . "))
            + sin(radians(" .$latitude. "))
            * sin(radians(projects.latitude))) AS distance"))->having('distance', '<=', $radius)->orderBy("distance", 'asc');
        })
        ->when($type, function ($q) use ($type) {
            return $q->where('project_type', $type);
        })
        ->when($min_range and $max_range, function ($q) use ($min_range, $max_range) {
            return $q->whereBetween('cost', [$min_range, $max_range]);
        })
        ->with('category', 'employer')
        ->latest('id')
        ->get();

        // return response()->json($projects);

        return response()->json([
            'status' => $projects->count() > 0 ? true : false,
            'projects_count' => $projects->count(),
            'projects' => $projects,
        ], 200);
    }

    public function employer_projects(Request $request) {
        if(!$request->header('user_id')) return response()->json(['status' => false], 403);

        $user_id = $request->header('user_id');
        $employer = Employer::where('user_id', $user_id)->first();
        if(!$employer) return response()->json(['status' => false], 403);

        $projects = Project::where('employer_id', $employer->id)->get();

        return response()->json([
            'status' => true,
            'projects' => $projects
        ], 200);
    }

    public function employer_ongoing_projects(Request $request) {
        if(!$request->header('user_id')) return response()->json(['status' => false], 403);

        $user_id = $request->header('user_id');
        $employer = Employer::where('user_id', $user_id)->first();
        if(!$employer) return response()->json(['status' => false], 403);

        $proposals = ProjectProposal::where('employer_id', $employer->id)
        ->where('status', 'approved')
        ->with('project', 'contract')
        ->whereHas('contract', function($q) {
            return $q->where('proposal_type', 'proposal');
        })->get();

        $offers = ProjectOffer::where('employer_id', $employer->id)
        ->where('status', 'approved')
        ->with('project', 'contract')
        ->whereHas('contract', function($q) {
            return $q->where('proposal_type', 'offer');
        })->get();

        $ongoing_projects = $proposals->concat($offers);

        return response()->json([
            'status' => true,
            'ongoing_projects' => $ongoing_projects
        ], 200);

    }

    public function employer_completed_projects(Request $request) {
        if(!$request->header('user_id')) return response()->json(['status' => false], 403);

        $user_id = $request->header('user_id');
        $employer = Employer::where('user_id', $user_id)->first();
        if(!$employer) return response()->json(['status' => false], 403);

        $proposals = ProjectProposal::where('employer_id', $employer->id)
        ->where('status', 'completed')
        ->with('project', 'contract')
        ->whereHas('contract', function($q) {
            return $q->where('proposal_type', 'proposal');
        })->get();

        $offers = ProjectOffer::where('employer_id', $employer->id)
        ->where('status', 'completed')
        ->with('project', 'contract')
        ->whereHas('contract', function($q) {
            return $q->where('proposal_type', 'offer');
        })->get();

        $completed_projects = $proposals->concat($offers);

        return response()->json([
            'status' => true,
            'completed_projects' => $completed_projects
        ], 200);
    }

    public function freelancer_ongoing_projects(Request $request) {
        if(!$request->header('user_id')) return response()->json(['status' => false], 403);

        $user_id = $request->header('user_id');
        $freelancer = Freelancer::where('user_id', $user_id)->first();
        if(!$freelancer) return response()->json(['status' => false], 403);

        $proposals = ProjectProposal::where('freelancer_id', $freelancer->id)
        ->where('status', 'approved')
        ->with('project', 'contract')
        ->whereHas('contract', function($q) {
            return $q->where('proposal_type', 'proposal');
        })->get();

        $offers = ProjectOffer::where('freelancer_id', $freelancer->id)
        ->where('status', 'approved')
        ->with('project', 'contract')
        ->whereHas('contract', function($q) {
            return $q->where('proposal_type', 'offer');
        })->get();

        $ongoing_projects = $proposals->concat($offers);

        return response()->json([
            'status' => true,
            'ongoing_projects' => $ongoing_projects
        ], 200);
    }

    public function freelancer_completed_projects(Request $request) {
        if(!$request->header('user_id')) return response()->json(['status' => false], 403);

        $user_id = $request->header('user_id');
        $freelancer = Freelancer::where('user_id', $user_id)->first();
        if(!$freelancer) return response()->json(['status' => false], 403);

        $proposals = ProjectProposal::where('freelancer_id', $freelancer->id)
        ->where('status', 'completed')
        ->with('project', 'contract')
        ->whereHas('contract', function($q) {
            return $q->where('proposal_type', 'proposal');
        })->get();

        $offers = ProjectOffer::where('freelancer_id', $freelancer->id)
        ->where('status', 'completed')
        ->with('project', 'contract')
        ->whereHas('contract', function($q) {
            return $q->where('proposal_type', 'offer');
        })->get();

        $completed_projects = $proposals->concat($offers);

        return response()->json([
            'status' => true,
            'completed_projects' => $completed_projects
        ], 200);
    }

    public function create(Request $request) {
        $categories = ServiceCategory::all();
        $skills = Skill::toBase()->get();
        $employer = Employer::where('user_id', $request->header('user_id'))->first();

        return response()->json([
            'employer' => $employer,
            'categories' => $categories,
            'skills' => $skills,
        ]);
    }

    public function store(StoreProjectRequest $request) {
        $images = array();
        if(!$request->header('user_id')) return response()->json(['status' => false], 403);
        if($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $key => $attachment) {
                $image_name = $attachment->getClientOriginalName();
                $save_file = $attachment->move(public_path().'/images/projects', $image_name);
                array_push($images, $image_name);
            }
        }

        $json_images = json_encode($images);
        $user_id = $request->header('user_id');

        $employer = Employer::where('user_id', $user_id)->first();
        if(!$employer) return response()->json(['status' => false], 403);

        // #compute total cost
        // $system_deduction = intval($request->cost) * 0.10;
        // $total_cost = intval($request->cost) - $system_deduction;

        $start_date = date_create($request->start_date);
        $end_date = date_create($request->end_date);

        $project = Project::create(array_merge($request->validated(), [
            'employer_id' => $employer->id,
            'attachments' => $json_images,
            'skills' => $request->skills,
            'start_date' => date_format($start_date, 'Y-m-d'),
            'end_date' => date_format($end_date, 'Y-m-d'),
            'datetime' => $request->datetime,
            'total_cost' => $request->cost,
        ]));

        if($project) return response()->json([
            'status' => true,
            'project' => $project,
            'message' => 'Project Created Successfully'
        ], 201);
    }

    public function edit(Request $request) {
        $project = Project::where('id', $request->project_id)->firstOrFail();
        $categories = ServiceCategory::all();
        $skills = Skill::all();
        $project_images = json_decode($project->attachments);

        return response()->json([
            'status' => true,
            'categories' => $categories,
            'skills' => $skills,
            'project_images' => $project_images,
            'project' => $project,
        ]);
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

        $start_date = date_create($request->start_date);
        $end_date = date_create($request->end_date);

        $project = Project::where('id', $request->id)->update(array_merge($request->validated(), [
            'employer_id' => $request->employer,
            'attachments' => $json_images,
            'skills' => json_encode($request->skills),
            'start_date' => date_format($start_date, 'Y-m-d'),
            'end_date' => date_format($end_date, 'Y-m-d'),
            'datetime' => $request->datetime,
            'total_cost' => $request->cost,
        ]));

        if($project) {
            return response()->json([
                'status' => true,
                'message' => 'Update Project Successfully',
            ], 200);
        }
    }
}
