<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\ProjectContract;
use App\Models\Project;
use App\Models\ProjectProposal;
use App\Models\ProjectOffer;
use App\Models\Freelancer;
use App\Models\Employer;

use DB;

use SimpleSoftwareIO\QrCode\Facades\QrCode;


use App\Http\Requests\ProjectContract\StoreProjectContract;


class ProjectContractController extends Controller
{

    public function contract(Request $request) {
        $contract = ProjectContract::where('id', $request->id)->with('proposal', 'project')->firstOrFail();

        $employer = Employer::where('user_id', session()->get('id'))->first();
        $freelancer = Freelancer::where('user_id', session()->get('id'))->first();

        # if the user is employer
        if(session()->get('role') == 'employer') {
            if($contract->employer_id != $employer->id) abort(403);
        }

        # if the user is freelancer
        if(session()->get('role') == 'freelancer') {
            if($contract->freelancer_id != $freelancer->id) abort(403);
        }

        return view("UserAuthScreens.contracts.contract", compact('contract'));
    }

    public function view_code(Request $request) {

        abort_if(session()->get('role') != 'freelancer', 403);

        $contract = ProjectContract::where('id', $request->id)->first();

        $employer = Employer::where('user_id', session()->get('id'))->first();
        $freelancer = Freelancer::where('user_id', session()->get('id'))->first();


        # if the user is freelancer
        if(session()->get('role') == 'freelancer') {
            if($contract->freelancer_id != $freelancer->id) abort(403);
        }

        $redirect_link = url('') . '/project/contract/' . $contract->code;

        return view('UserAuthScreens.contracts.view-contract-code', compact('contract', 'redirect_link'));
    }

    public function track(Request $request) {
        $contract = ProjectContract::where('id', $request->id)->firstOrFail();

        if(!$contract->is_verify_code) return redirect()->route('contract.validate_code')->with('fail', 'Verify First before continue.');

        return view('UserAuthScreens.contracts.track-contract');
    }

    public function validate_code(Request $request) {
        return view('UserAuthScreens.contracts.code-verification-form');
    }

    public function create(Request $request) {
        if($request->type == 'proposal') {
            $data = ProjectProposal::where('id', $request->id)->with('project')->firstOrFail();
        }

        if($request->type == 'offer') {
            $data = ProjectOffer::where('id', $request->id)->firstOrFail();
        }

        return view('UserAuthScreens.contracts.create-contract', compact('data'));
    }

    public function store(StoreProjectContract $request) {

        try {

            #generate uuid
            $code = Str::random(10);

            DB::beginTransaction();

            #create project contract
            ProjectContract::create(array_merge($request->validated(), [
                'code' => $code
            ]));

            #update project status
            Project::where('id', $request->project_id)->update([
                'status' => 'approved'
            ]);

            #update project proposal status
            ProjectProposal::where('id', $request->proposal_id)->update([
                'status' => 'approved'
            ]);

            DB::commit();

            return redirect('/employer/projects/ongoing')->with('success', 'Success on creating contract');

        } catch (\ValidationException $e) {
            DB::rollback();
            throw $e;
        }
    }
}
