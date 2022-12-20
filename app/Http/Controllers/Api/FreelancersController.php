<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Freelancer;
use App\Models\Users;

class FreelancersController extends Controller
{
    //

    public function freelancers(Request $request) {
        $freelancers = Freelancer::with('user', 'freelancer_skills')->get();
        return response()->json([
            'status' => true,
            'freelancers' => $freelancers
        ], 200);
    }
}
