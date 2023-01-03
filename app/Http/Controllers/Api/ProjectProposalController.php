<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectProposalController extends Controller
{
    public function store(Request $request) {

        $freelancer = Freelancer::where('user_id', $request->id)->firstOrFail();
        $images = array();
        if($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $key => $attachment) {
                $image_name = $attachment->getClientOriginalName();
                $save_file = $attachment->move(public_path().'/images/projects/proposal_attachments', $image_name);
                array_push($images, $image_name);
            }
        }

        $json_images = json_encode($images);

        $proposal = ProjectProposal::create(array_merge($request->validated(), [
            'project_id' => $request->project_id,
            'employer_id' => $request->employer_id,
            'freelancer_id' => $freelancer->id,
            'status' => 'pending',
            'attachments' => $json_images
        ]));

    }
}
