<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ProjectProposal;
use App\Models\Freelancer;
use App\Models\Employer;
use App\Models\Project;
use App\Models\ProjectMessage;
use Carbon\Carbon;

use App\Http\Requests\ProjectProposal\StoreProjectProposal;

use Yajra\DataTables\Facades\DataTables;

class ProjectProposalController extends Controller
{

    public function proposals_for_employers() {
        #get the employer data
        $employer = Employer::where('user_id', session()->get('id'))->firstOrFail();

        #get the projects lists data
        $projects = Project::where('employer_id', $employer->id)->where('status', 'pending')->get();
        return view('UserAuthScreens.proposals.employer.index-proposals', compact('projects'));
    }

    public function fetch_proposals_for_employers(Request $request) {
        # if the request was not able to use ajax
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

        #get the pending proposals
        $pending_proposals = $freelancer->project_proposals()->where('status', 'pending')->with('project')->get();

        #get the approved proposals
        $approved_proposals = $freelancer->project_proposals()->where('status', 'approved')->with('project')->get();

        return view('UserAuthScreens.proposals.freelancer.index-proposals', compact('freelancer', 'pending_proposals', 'approved_proposals'));
    }


    public function proposal(Request $request) {
        $role = session()->get('role');

        # get the proposal data
        $proposal = ProjectProposal::where('id', $request->id)->with('employer', 'freelancer', 'project')->firstOrFail();

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

        # return to view template in UserAuthScreens.proposals.proposal-view
        return view('UserAuthScreens.proposals.proposal-view', compact('proposal', 'receiver', 'incoming_msg_id', 'outgoing_msg_id', 'isAvailableDate'));
    }
}
