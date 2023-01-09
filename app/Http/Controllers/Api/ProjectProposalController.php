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

    public function proposal(Request $request) {
        $role = $request->header('role');
        if(!$role) return response()->json(['status' => false, 'message' => 'Forbidden'], 403);

        # get the proposal data
        $proposal = ProjectProposal::where('id', $request->id)->with('employer', 'freelancer', 'project')->firstOr(function() {
           return response()->json(['status' => false, 'message' => 'Not Found'], 404);
        });

        # set initial receiver to employer
        $receiver = Employer::where('id', $proposal->employer_id)->with('user')->first();

        # set initial value for isAvailableDate
        $isAvailableDate = true;

        #if the login user is employer then the receiver is freelancer
        if($role == 'employer') {
            $receiver = Freelancer::where('id', $proposal->freelancer_id)->with('user')->first();
            $isAvailableDate = in_array($proposal->project->start_date, $receiver->notAvailableDates()) || in_array($proposal->project->end_date, $receiver->notAvailableDates()) ? false : true;
        }

        # set initial outgoing and incoming messages user id
        $incoming_msg_id = $proposal->freelancer_id;
        $outgoing_msg_id = $proposal->employer_id;

        # if the login user is freelancer then change the outgoing and incoming messages user id
        if($role == 'freelancer') {
            $incoming_msg_id = $proposal->employer_id ;
            $outgoing_msg_id = $proposal->freelancer_id;
        }

        return response()->json([
            'status' => true,
            'proposal' => $proposal,
            'receiver' => $receiver,
            'incoming_msg_id' => $incoming_msg_id,
            'outgoing_msg_id' => $outgoing_msg_id,
            'isAvailableDate' => $isAvailableDate,
        ], 200);
    }

    public function proposals_for_freelancers(Request $request) {
        $user_id = $request->header('user_id');
        if(!$user_id) return response()->json(['status' => false, 'message' => 'Not Found'], 404);

        #get the freelancer data
        $freelancer = Freelancer::where('user_id', $user_id)->with('project_proposals', 'project_offers')->firstOrFail();

        #get the pending proposals
        $pending_proposals = $freelancer->project_proposals()->where('status', 'pending')->with('project')->get();

        #get the approved proposals
        $approved_proposals = $freelancer->project_proposals()->where('status', 'approved')->with('project')->get();

        #get the offers
        $offers = $freelancer->project_offers()->with('project')->get();

        return response()->json([
            'freelancer' => $freelancer,
            'pending_proposals' => $pending_proposals,
            'approved_proposals' => $approved_proposals,
            'offers' => $offers
        ], 200);
    }


}
