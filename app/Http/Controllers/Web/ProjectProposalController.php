<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ProjectProposal;
use App\Models\Freelancer;
use App\Models\Employer;
use App\Models\Project;
use Carbon\Carbon;

use Yajra\DataTables\Facades\DataTables;

class ProjectProposalController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'offer_price' => 'required|numeric',
            'estimated_days' => 'required|numeric',
            'cover_letter' => 'required',
            'address' => 'required'
        ]);
        
        $freelancer = Freelancer::where('user_id', session()->get('id'))->first();
        if(!$freelancer) return back()->with('fail', "The User doesn't exist.");
        
        $images = array();
        if($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $key => $attachment) {
                $image_name = $attachment->getClientOriginalName();
                $save_file = $attachment->move(public_path().'/images/projects/proposal_attachments', $image_name);
                array_push($images, $image_name);
            }
        }

        $json_images = json_encode($images);

        $save = ProjectProposal::create([
            'project_id' => $request->project_id,
            'employer_id' => $request->employer_id,
            'freelancer_id' => $freelancer->id,
            'offer_price' => $request->offer_price,
            'estimated_days' => $request->estimated_days,
            'address' => $request->address,
            'cover_letter' => $request->cover_letter,
            'project_cost_type' => 'Fixed',
            'status' => 'pending',
            'attachments' => $json_images
        ]);

        if($save) return back()->with('success', 'Proposal sent successfully');

        return back()->with('fail', 'Something went wrong.');
    }

    public function proposals_for_employers() {
        $employer = Employer::where('user_id', session()->get('id'))->first();
        $proposals = ProjectProposal::where('employer_id', $employer->id)->where('status', 'pending')->with('employer', 'freelancer', 'project')->whereHas('project', function($query) {
            $query->where('expiration_date', '>', Carbon::now())->orWhere('isExpired', 0);
        })->cursorPaginate(10);
        return view('UserAuthScreens.proposals.employer-proposals', compact('proposals'));
    }

    public function proposals_for_freelancers() {
        $freelancer = Freelancer::where('user_id', session()->get('id'))->first();
        $proposals = ProjectProposal::where('freelancer_id', $freelancer->id)->where('status', 'pending')->with('employer', 'freelancer', 'project')->whereHas('project', function($query) {
            $query->where('expiration_date', '>', Carbon::now())->orWhere('isExpired', 0);
        })->cursorPaginate(10);
        return view('UserAuthScreens.proposals.freelancer-proposals', compact('proposals'));
    }


    public function project_proposal_information(Request $request) {
        $role = session()->get('role');
        $proposal = ProjectProposal::where('id', $request->id)->with('employer', 'freelancer', 'project')->first();
        // $user_model = $role == 'freelancer' ? Employer::class : Freelancer::class;
        
        $receiver = Employer::where('id', $proposal->employer_id)->with('user')->first();

        if($role == 'employer') {
            $receiver = Freelancer::where('id', $proposal->freelancer_id)->with('user')->first();
        } 
        
        $incoming_msg_id = $role == 'freelancer' ? $proposal->employer_id : $proposal->freelancer_id;
        $outgoing_msg_id = $role == 'freelancer' ? $proposal->freelancer_id : $proposal->employer_id;
        
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
}