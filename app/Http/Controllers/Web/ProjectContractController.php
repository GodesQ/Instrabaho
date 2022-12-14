<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ProjectContract;
use App\Models\Project;
use App\Models\ProjectProposal;
use App\Models\Freelancer;
use App\Models\Employer;

use DB;

use App\Http\Requests\ProjectContract\StoreProjectContract;


class ProjectContractController extends Controller
{

    public function contract(Request $request) {
        $contract = ProjectContract::where('id', $request->id)->with('proposal', 'project')->firstOrFail();
        return view("UserAuthScreens.contracts.contract", compact('contract'));
    }

    public function create(Request $request) {
        $proposal = ProjectProposal::where('id', $request->id)->with('project')->firstOrFail();
        return view('UserAuthScreens.contracts.create-contract', compact('proposal'));
    }

    public function store(StoreProjectContract $request) {

        try {

            DB::beginTransaction();
            #create project contract
            ProjectContract::create($request->validated());

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
