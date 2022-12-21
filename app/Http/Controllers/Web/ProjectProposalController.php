<?php

namespace App\Http\Controllers\Web;

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

use App\Actions\StoreNotificationAction;

use Yajra\DataTables\Facades\DataTables;

class ProjectProposalController extends Controller
{

    public function store(StoreProjectProposal $request, StoreNotificationAction $action) {
        dd($action->createNotification());
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

        $save = ProjectProposal::create(array_merge($request->validated(), [
            'project_id' => $request->project_id,
            'employer_id' => $request->employer_id,
            'freelancer_id' => $freelancer->id,
            'status' => 'pending',
            'attachments' => $json_images
        ]));

        if($save) {
            $action->createNotification($request);
            return back()->with('success', 'Proposal sent successfully');
        }
        return back()->with('fail', 'Something went wrong.');
    }

    public function proposals_for_employers() {
        #get the employer data
        $employer = Employer::where('user_id', session()->get('id'))->firstOrFail();

        #get the projects lists data
        $projects = Project::where('employer_id', $employer->id)->where('status', 'pending')->get();
        return view('UserAuthScreens.proposals.employer.index-proposals', compact('projects'));
    }

    public function fetch_proposals_for_employers(Request $request) {
        # if the request was not ajax
        abort_if(!$request->ajax(), 404);

        #get the request data
        $project_id = $request->input('project_id');

        # get the proposal lists and create pagination
        $proposals = ProjectProposal::where('project_id', $project_id)->with('freelancer')->paginate(10);

        # create a html to render in proposals lists
        $view_data = view('UserAuthScreens.proposals.employer.proposals', compact('proposals'))->render();

        return response()->json([
            'view_data' => $view_data,
            'proposals' => $proposals
        ]);
    }

    public function proposals_for_freelancers() {

        #get the freelancer data
        $freelancer = Freelancer::where('user_id', session()->get('id'))->with('project_proposals', 'project_offers')->firstOrFail();

        #get the pending proposals
        $pending_proposals = $freelancer->project_proposals()->where('status', 'pending')->with('project')->get();

        #get the approved proposals
        $approved_proposals = $freelancer->project_proposals()->where('status', 'approved')->with('project')->get();

        #get the offers
        $offers = $freelancer->project_offers()->with('project')->get();

        return view('UserAuthScreens.proposals.freelancer.index-proposals', compact('freelancer', 'pending_proposals', 'approved_proposals', 'offers'));
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
