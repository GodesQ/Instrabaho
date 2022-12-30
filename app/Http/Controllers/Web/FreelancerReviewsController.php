<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FreelancerReview;
use App\Models\Freelancer;
use App\Models\Employer;
use App\Models\ProjectContract;

use App\Http\Requests\ReviewFreelancer\StoreReviewFreelancerRequest;

class FreelancerReviewsController extends Controller
{
    public function create(Request $request) {
        if($request->job_type == 'project') {
            $contract = ProjectContract::where('id', $request->contract_id)->with('project', 'freelancer', 'employer')->firstOrFail();
        }
        $job_type = $request->job_type;
        return view('UserAuthScreens.review_freelancer.create', compact('contract', 'job_type'));
    }

    public function store(StoreReviewFreelancerRequest $request) {
        dd($request->validated());
    }
}
