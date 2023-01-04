<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Project;
use DB;

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
            return $q->orWhere(DB::raw('lower(title)', 'like', '%' . strtolower($title) . '%'));
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
        ->toSql();

        return response()->json($projects);

        return response()->json([
            'status' => $projects->count() > 0 ? true : false,
            'projects_count' => $projects->count(),
            'projects' => $projects,
        ], 200);
    }

    public function store(Request $request) {
        $images = array();

        if($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $key => $attachment) {
                $image_name = $attachment->getClientOriginalName();
                $save_file = $attachment->move(public_path().'/images/projects', $image_name);
                array_push($images, $image_name);
            }
        }

        $json_images = json_encode($images);
        $user_id = $request->id;

        $employer = Employer::where('user_id', $user_id)->first();

        // #compute total cost
        // $system_deduction = intval($request->cost) * 0.10;
        // $total_cost = intval($request->cost) - $system_deduction;

        $start_date = date_create($request->start_date);
        $end_date = date_create($request->end_date);

        $create = Project::create(array_merge($request->validated(), [
            'employer_id' => $employer->id,
            'attachments' => $json_images,
            'skills' => json_encode($request->skills),
            'start_date' => date_format($start_date, 'Y-m-d'),
            'end_date' => date_format($end_date, 'Y-m-d'),
            'datetime' => $request->datetime,
            'total_cost' => $request->cost,
        ]));

        if($create) return response()->json([
            'status' => true,
            'message' => 'Project Created Successfully'
        ], 201);
    }
}
