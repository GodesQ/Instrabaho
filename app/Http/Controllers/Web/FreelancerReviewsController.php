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
        $data = $request->validated();
        $attachment = $request->file('review_image');
        $image_name =  null;
        if($attachment) {
            $image_name = $attachment->getClientOriginalName();
            $save_file = $attachment->move(public_path().'/images/freelancer_reviews', $image_name);
        }

        $review = FreelancerReview::create(array_merge($data, ['review_image' => $image_name]));

        if($request->job_type == 'project') {
            ProjectContract::where('id', $request->job_id)->update([
                'is_employer_review' => true
            ]);
        }

        if($review) return redirect()->route('employer.projects.completed')->withSuccess('Review Successfully Submitted.');

    }
}
