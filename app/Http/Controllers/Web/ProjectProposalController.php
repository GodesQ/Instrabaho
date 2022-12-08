<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ProjectProposal;
use App\Models\Freelancer;
use App\Models\Employer;
use App\Models\Project;
use Carbon\Carbon;

use App\Http\Requests\ProjectProposal\StoreProjectProposal;

use Yajra\DataTables\Facades\DataTables;

class ProjectProposalController extends Controller
{
    public function store(StoreProjectProposal $request) {

        $freelancer = Freelancer::where('user_id', session()->get('id'))->firstOrFail();

        $images = array();
        if($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $key => $attachment) {
                $image_name = $attachment->getClientOriginalName();
                $save_file = $attachment->move(public_path().'/images/projects/proposal_attachments', $image_name);
                array_push($images, $image_name);
            }
        }

        $json_images = json_encode($images);

        $save = ProjectProposal::create(array_merge($request->validated(),[
            'project_id' => $request->project_id,
            'employer_id' => $request->employer_id,
            'freelancer_id' => $freelancer->id,
            'project_cost_type' => 'Fixed',
            'status' => 'pending',
            'attachments' => $json_images
        ]));

        if($save) return back()->with('success', 'Proposal sent successfully');

        return back()->with('fail', 'Something went wrong.');
    }

    public function proposals_for_employers() {
        #get the employer data
        $employer = Employer::where('user_id', session()->get('id'))->firstOrFail();

        #get the projects lists data
        $projects = Project::where('employer_id', $employer->id)->where('status', 'pending')->where('expiration_date', '>=', Carbon::now())->toBase()->get();

        return view('UserAuthScreens.proposals.employer.index-proposals', compact('projects'));
    }

    public function fetch_proposals_for_employers(Request $request) {
        # if the request is not using ajax
        abort_if(!$request->ajax(), 404);

        #get the request data
        $min = $request->input('min');
        $max = $request->input('max');
        $project_id = $request->input('project_id');

        # get the proposal lists and create pagination
        $proposals = ProjectProposal::where('project_id', $project_id)->when($min && $max, function ($q) use ($min, $max) {
            return $q->whereBetween('offer_price', [$min, $max]);
        })->with('freelancer')->paginate(10);

        # create a html to render in proposals lists
        $view_data = view('UserAuthScreens.proposals.employer.proposals', compact('proposals'))->render();

        return response()->json([
            'view_data' => $view_data,
            'proposals' => $proposals
        ]);
    }

    public function proposals_for_freelancers() {
        #get the freelancer data
        $freelancer = Freelancer::where('user_id', session()->get('id'))->with('project_proposals')->firstOrFail();
        $pending_proposals = $freelancer->project_proposals()->where('status', 'pending')->with('project')->whereHas('project', function($query) {
            $query->where('expiration_date', '>', Carbon::now())->where('status', 'pending');
        })->get();

        $approved_proposals = $freelancer->project_proposals()->where('status', 'approved')->with('project')->whereHas('project', function($query) {
            $query->where('expiration_date', '>', Carbon::now())->where('status', 'pending');
        })->get();

        return view('UserAuthScreens.proposals.freelancer.index-proposals', compact('freelancer', 'pending_proposals', 'approved_proposals'));
    }


    public function proposal(Request $request) {
        $role = session()->get('role');

        # get the proposal data
        $proposal = ProjectProposal::where('id', $request->id)->with('employer', 'freelancer', 'project')->firstOrFail();

        # set initial receiver to employer
        $receiver = Employer::where('id', $proposal->employer_id)->with('user')->first();

        #if the login user is employer then the receiver is freelancer
        if($role == 'employer') $receiver = Freelancer::where('id', $proposal->freelancer_id)->with('user')->first();

        # set initial outgoing and incoming messages user id
        $incoming_msg_id = $proposal->freelancer_id;
        $outgoing_msg_id = $proposal->employer_id;

        # if the login user is freelancer then change the outgoing and incoming messages user id
        if($role == 'freelancer') {
            $incoming_msg_id = $proposal->employer_id ;
            $outgoing_msg_id = $proposal->freelancer_id;
        }

        # return to view template in UserAuthScreens.proposals.proposal-view
        return view('UserAuthScreens.proposals.proposal-view', compact('proposal', 'receiver', 'incoming_msg_id', 'outgoing_msg_id'));
    }

    public function update_proposal_status(Request $request) {

        $update = ProjectProposal::where('id', $request->proposal_id)->update([
            'status' => $request->status
        ]);

        $project_id = $request->project_id;

        if($request->status == 'approved') {
            $update_project = Project::where('id', $project_id)->update([
                'status' => $request->status,
            ]);
        }

        if($update) {
            return response()->json([
                'status' => 201,
                'message' => 'Update Status Successfully'
            ]);
        }

        return response()->json([
            'status' => 500,
            'message' => 'Failed to Update'
        ]);
    }
}
