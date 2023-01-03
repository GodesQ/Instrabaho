<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Project;

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
        $address = $request->input('address');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $type = $request->input('type');
        $radius = $request->input('radius') ? $request->input('radius') : 10;
        $result = $request->input('result') ? $request->input('result') : 5;

        $projects = Project::select('*')
        ->when($title, function($q) use ($title) {
            return $q->where(DB::raw('lower(title)', 'like', '%' . strtolower($title) . '%'));
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
        ->when($my_range, function ($q) use ($my_range) {
            $range = explode(';', $my_range);
            return $q->whereBetween('cost', [$range[0], $range[1]]);
        })
        ->where('status', '!=', 'completed')
        ->with('category', 'employer')
        ->latest('id')
        ->get();

        return response()->json([
            'status' => true,
            'projects' => $projects,
        ], 200);
    }

    public function create(Request $request) {

    }
}
