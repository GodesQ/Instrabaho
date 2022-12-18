<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Project;

class ProjectsController extends Controller
{
    public function projects() {
        $projects = Project::all();
        return response($projects, 200);
    }

    public function create(Request $request) {
        
    }
}
