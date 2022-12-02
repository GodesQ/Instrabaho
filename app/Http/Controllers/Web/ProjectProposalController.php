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
        $projects = Project::where('employer_id', $employer->id)->where('expiration_date', '>=', Carbon::now())->toBase()->get();

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
            return $q->whereBetween('cost', [$min, $max]);
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
        return view('UserAuthScreens.proposals.freelancer.index-proposals', compact('freelancer'));
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

        # if the login user is freelancer then the change the outgoing and incoming messages user id
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

    public function ongoing(Request $request) {
        if(session()->get('role') == 'freelancer') {
            $freelancer = Freelancer::where('user_id', session()->get('id'))->first();
            $ongoing_projects = ProjectProposal::where('freelancer_id', $freelancer->id)
            ->where('status', 'approved')
            ->with('project')
            ->whereHas('project', function($query) {
                $query->where('expiration_date', '>', Carbon::now())->orWhere('isExpired', 0);
            })
            ->cursorPaginate(10);
        } else {
            $employer = Employer::where('user_id', session()->get('id'))->first();
            $ongoing_projects = ProjectProposal::where('employer_id', $employer->id)
            ->where('status', 'approved')
            ->with('project')
            ->whereHas('project', function($query) {
                $query->where('expiration_date', '>', Carbon::now())->orWhere('isExpired', 0);
            })
            ->cursorPaginate(10);
        }

        return view('UserAuthScreens.proposals.ongoing.ongoing-project', compact('ongoing_projects'));
    }

    public function completed(Request $request) {
        if(session()->get('role') == 'freelancer') {
            $freelancer = Freelancer::where('user_id', session()->get('id'))->first();
            $completed_projects = ProjectProposal::where('freelancer_id', $freelancer->id)
            ->where('status', 'completed')
            ->with('project')
            ->cursorPaginate(10);
        } else {
            $employer = Employer::where('user_id', session()->get('id'))->first();
            $completed_projects = ProjectProposal::where('employer_id', $employer->id)
            ->where('status', 'completed')
            ->with('project')
            ->cursorPaginate(10);
        }

        return view('UserAuthScreens.proposals.completed.completed-project', compact('completed_projects'));
    }

    // public function approved(Request $request) {
    //     return view('UserAuthScreens.proposals.approved-proposals');
    // }

    // public function get_approved_proposals(Request $request) {
    //     $today = date('Y-m-d');
    //     if($request->ajax()) {
    //         $role = session()->get('role');
    //         $user_id = session()->get('id');
    //         $user = $role == 'freelancer' ? Freelancer::where('user_id', $user_id)->first() : Employer::where('user_id', $user_id)->first();
    //         $data = ProjectProposal::where(function($query) use ($role, $user) {
    //             if($role == 'freelancer') {
    //                 $query->where('freelancer_id', $user->id);
    //             } else{
    //                 $query->where('employer_id', $user->id);
    //             }
    //         })->where('status', '!=', 'pending')
    //         ->with('project', 'employer', 'freelancer')
    //         ->whereHas('project', function ($query) use ($today) {
    //             $query->where('expiration_date', '>', $today);
    //         });

    //         return Datatables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('title', function($row){
    //                 return $row->project->title;
    //             })
    //             ->addColumn('user', function($row){
    //                 if(session()->get('role') == 'employer') {
    //                     return $row->freelancer->display_name;
    //                 }
    //                 return $row->employer->display_name;
    //             })
    //             ->addColumn('offer_price', function($row){
    //                 return number_format($row->offer_price, 2);
    //             })
    //             ->addColumn('estimated_days', function($row){
    //                 return $row->estimated_days . " Days";
    //             })
    //             ->addColumn('status', function($row){
    //                 $status = "<div class='badge badge-info'>$row->status</div>";
    //                 return $status;
    //             })
    //             ->addColumn('action', function($row){
    //                 $btn = '<a href="/project_proposal_information/'. $row->id .'" class="edit btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
    //                         <a href="javascript:void(0)" class="edit btn btn-danger btn-sm">Cancel Service</a>';
    //                 return $btn;
    //             })
    //             ->rawColumns(['action', 'status'])
    //             ->toJson();
    //     }
    // }
}
