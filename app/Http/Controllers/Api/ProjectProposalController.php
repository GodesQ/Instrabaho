<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ProjectProposal;
use App\Models\ProjectOffer;
use App\Models\Freelancer;
use App\Models\Employer;
use App\Models\Project;
use App\Models\ProjectMessage;

use Carbon\Carbon;

use App\Http\Requests\ProjectProposal\StoreProjectProposal;


class ProjectProposalController extends Controller
{
    public function store(StoreProjectProposal $request) {

        if(!$request->header('user_id')) return response()->json(['status' => false, 'message' => 'Forbidden'], 403);

        $freelancer = Freelancer::where('user_id', $request->header('user_id'))->firstOrFail();
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
            'employer_id' => $request->employer_id,
            'freelancer_id' => $freelancer->id,
            'status' => 'pending',
            'attachments' => $json_images
        ]));

        if($proposal) {
            return response()->json([
                'status' => true,
                'message' => 'Proposal Submitted Successfully'
            ], 201);
        }
    }
}
