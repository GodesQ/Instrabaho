<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EmployerReview;
use App\Models\Freelancer;
use App\Models\Employer;
use App\Models\ProjectContract;

use App\Http\Requests\ReviewEmployer\StoreReviewEmployerRequest;


class EmployerReviewsController extends Controller
{
    public function create(Request $request) {
        if($request->job_type == 'project') {
            $contract = ProjectContract::where('id', $request->contract_id)->with('project', 'freelancer', 'employer')->firstOrFail();
        }
        $job_type = $request->job_type;
        return view('UserAuthScreens.review_employer.create', compact('contract', 'job_type'));
    }

    public function store(StoreReviewEmployerRequest $request) {
        $data = $request->validated();
        $attachment = $request->file('review_image');
        $image_name =  null;
        if($attachment) {
            $image_name = $attachment->getClientOriginalName();
            $save_file = $attachment->move(public_path() . '/images/employer_reviews', $image_name);
        }

        $review = EmployerReview::create(array_merge($data, ['review_image' => $image_name]));

        if($request->job_type == 'project') {
            ProjectContract::where('id', $request->job_id)->update([
                'is_freelancer_review' => true
            ]);
        }

        if(session()->get('role') == 'freelancer') {
            if($review) return redirect()->route('freelancer.projects.completed')->withSuccess('Review Successfully Submitted.');
        } else {
            if($review) return redirect()->route('employer.projects.completed')->withSuccess('Review Successfully Submitted.');
        }

    }
}
