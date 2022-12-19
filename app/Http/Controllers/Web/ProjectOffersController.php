<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ProjectOffer;
use App\Models\Employer;
use App\Models\Freelancer;
use App\Http\Requests\ProjectOffer\StoreProjectOfferRequest;

class ProjectOffersController extends Controller
{
    //
    public function employer_create_offer(Request $request) {
        $user_id = session()->get('id');
        $employer = Employer::where('user_id', $user_id)->with('projects')->firstOrFail();
        $freelancer = Freelancer::where('display_name', $request->freelancer)->firstOrFail();

        $pending_projects = $employer->projects()->where('status', 'pending')->get();

        return view('UserAuthScreens.projects_offers.create-offer', compact('employer', 'freelancer', 'pending_projects'));
    }

    public function store(StoreProjectOfferRequest $request) {

        # check if the offer was already submitted in freelancer
        $isOfferExist = ProjectOffer::where('freelancer_id', $request->freelancer_id)->where('project_id', $request->project_id)->exists();
        if($isOfferExist) return back()->withErrors('Fail. This offer already exist on our record.');

        $data = array_diff($request->validated(), [$request->private_message]);
        $submit_offer = ProjectOffer::create($data);

        if($submit_offer) return back()->withSuccess('Offer Submitted Successfully');
    }

    public function offer(Request $request) {
        $project_offer = ProjectOffer::where('id', $request->id)->firstOrFail();

        # set initial receiver to employer
        $receiver = Employer::where('id', $project_offer->employer_id)->with('user')->first();

        # set initial value for isAvailableDate
        $isAvailableDate = true;

        #if the login user is employer then the receiver is freelancer
        if(session()->get('role') == 'employer') {
            $receiver = Freelancer::where('id', $project_offer->freelancer_id)->with('user')->first();
            $isAvailableDate = in_array($project_offer->project->start_date, $receiver->notAvailableDates()) || in_array($proposal->project->end_date, $receiver->notAvailableDates()) ? false : true;
        }

        # set initial outgoing and incoming messages user id
        $incoming_msg_id = $project_offer->freelancer_id;
        $outgoing_msg_id = $project_offer->employer_id;

        # if the login user is freelancer then change the outgoing and incoming messages user id
        if(session()->get('role') == 'freelancer') {
            $incoming_msg_id = $project_offer->employer_id ;
            $outgoing_msg_id = $project_offer->freelancer_id;
        }

        return view('UserAuthScreens.projects_offers.offer-view', compact('project_offer', 'receiver', 'incoming_msg_id', 'outgoing_msg_id'));
    }



}
