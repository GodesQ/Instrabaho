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
use App\Models\ProjectContractTracker;
use App\Models\ProjectContractTrackerLog;

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

        if($contract->is_verify_code) return redirect()->route('contract.track', $contract->id)->with('success', 'Verify Successfully');

        $employer = Employer::where('user_id', session()->get('id'))->first();
        $freelancer = Freelancer::where('user_id', session()->get('id'))->first();

        # if the user is freelancer
        if(session()->get('role') == 'freelancer') {
            abort_if($contract->freelancer_id != $freelancer->id, 403);
        }

        $redirect_link = url('') . '/project/contract/' . $contract->code;

        return view('UserAuthScreens.contracts.view-contract-code', compact('contract', 'redirect_link'));
    }

    public function track(Request $request) {
        $contract = ProjectContract::where('id', $request->id)->with('project', 'proposal', 'tracker', 'freelancer', 'employer')->firstOrFail();
        if(!$contract->is_verify_code) {
            if(session()->get('role') == 'employer') {
                $employer = Employer::where('id', $contract->employer_id)->first();
                abort_if($employer->user_id != session()->get('id'), 403);
                return redirect()->route('contract.validate_code', $contract->id)->with('fail', 'Verify First before continue.');
            }

            if(session()->get('role') == 'freelancer') {
                $freelancer = Freelancer::where('id', $contract->freelancer_id)->first();
                abort_if($freelancer->user_id != session()->get('id'), 403);
                return redirect()->route('contract.code', $contract->id)->with('fail', 'Verify First before continue.');
            }
        }

        if(session()->get('role') == 'employer') {
            $employer = Employer::where('id', $contract->employer_id)->first();
            abort_if($employer->user_id != session()->get('id'), 403);
            return view('UserAuthScreens.contracts.track-contract', compact('contract'));
        }

        if(session()->get('role') == 'freelancer') {
            $freelancer = Freelancer::where('id', $contract->freelancer_id)->first();
            abort_if($freelancer->user_id != session()->get('id'), 403);
            return view('UserAuthScreens.contracts.track-contract', compact('contract'));
        }
    }

    public function validate_code(Request $request) {
        return view('UserAuthScreens.contracts.code-verification-form');
    }

    public function post_validate_code(Request $request) {
        $contract = ProjectContract::where('code', $request->code)->first();

        if($contract) {
            $contract->is_verify_code = true;
            $save = $contract->save();

            if($save) return redirect()->route('contract.track', $contract->id)->with('success', 'Verify Successfully');
        }

        return back()->with('fail', 'Fail! The code you submitted was invalid.');
    }

    public function start_working(Request $request) {
        $contract = ProjectContract::where('id', $request->id)->first();

        if($contract) {
            $contract->is_start_working = true;
            $contract->start_working_date = date('Y-m-d H:i:s');
            $save = $contract->save();

            if($save) {
                return response()->json([
                    'status' => true,
                    'message' => 'Contract Successfully Updated',
                    'start_working_date' => $contract->start_working_date,
                ]);
            }
        }

        return response()->json([
            'status' => false,
            'message' => 'Something went wrong! Please Try Again Later.'
        ]);
    }

    public function store_time(Request $request) {
        $contract = ProjectContract::where('id', $request->contract_id)->first();

        if(!$contract) return response()->json([
            'status' => false,
            'message' => 'Contract is not invalid',
        ]);

        $contract_tracker = ProjectContractTracker::where('contract_id', $contract->id)->first();

        if($contract_tracker) {
            $total_hours = $contract_tracker->hours + $request->current_hours;
            $total_minutes = $contract_tracker->minutes + $request->current_minute;

            $remaining_minutes = 0;

            # check if the total minutes is greater than 60
            if($total_minutes >= 60) {
                $remaining_minutes = $total_minutes - 60;
                $total_minutes = $remaining_minutes;
                $total_hours = $total_hours + 1;
            }

            $total_hours_cost = $contract->cost * $total_hours;

            if($total_minutes != 0) $total_hours_cost += $contract->cost / 60 * $total_minutes;

            $start_date = $request->start_date ? date_create($request->start_date) : null;
            $end_date = $request->end_date ? date_create($request->end_date) : null;

            # update
            $contract_tracker->hours = $total_hours;
            $contract_tracker->minutes = $total_minutes;
            $contract_tracker->total_hours_cost = $total_hours_cost;
            $contract_tracker->start_time = $start_date ? date_format($start_date, 'Y-m-d H:i:s') : null;
            $contract_tracker->stop_time = $end_date ? date_format($end_date, 'Y-m-d H:i:s') : null;
            $contract_tracker->status = $request->status;
            $save = $contract_tracker->save();

            # add log
            if($request->status == 'start') {
                $string_start_date = $start_date->format('Y-m-d h:i:s A');
                $log = ProjectContractTrackerLog::create([
                    'tracker_id' => $contract_tracker->id,
                    'log' => 'start on ' . $string_start_date
                ]);
            } else {
                $string_end_date = $end_date->format('Y-m-d h:i:s A');
                $log = ProjectContractTrackerLog::create([
                    'tracker_id' => $contract_tracker->id,
                    'log' => 'stop on ' . $string_end_date
                ]);
            }

            if($save) return response()->json([
                'status' => true,
                'message' => 'Success Updating Tracker',
                'total_hours_cost' => $total_hours_cost,
                'total_hours' => $total_hours,
                'total_minutes' => $total_minutes,
                'start_time' => $contract_tracker->start_time,
                'stop_time' => $contract_tracker->end_time
            ]);

        } else {
            $total_hours_cost = $contract->cost * $request->hours;
            $start_date = $request->start_date ? date_create($request->start_date) : null;
            $end_date = $request->end_date ? date_create($request->end_date) : null;

            $contract_tracker = ProjectContractTracker::create([
                'contract_id' => $contract->id,
                'minutes' => $request->current_minute,
                'hours' => $request->current_hours,
                'total_hours_cost' => $total_hours_cost,
                'start_time' => $start_date ? date_format($start_date, 'Y-m-d H:i:s') : null,
                'stop_time' => $end_date ? date_format($end_date, 'Y-m-d H:i:s') : null,
                'status' => $request->status
            ]);

            $contract->is_start_working = true;
            $contract->start_working_date = $start_date ? date_format($start_date, 'Y-m-d H:i:s') : null;
            $contract->save();

            # add log
            if($request->status == 'start') {
                $string_start_date = $start_date->format('Y-m-d h:i:s A');
                $log = ProjectContractTrackerLog::create([
                    'tracker_id' => $contract_tracker->id,
                    'log' => 'start on ' . $string_start_date
                ]);
            } else {
                $string_end_date = $end_date->format('Y-m-d h:i:s A');
                $log = ProjectContractTrackerLog::create([
                    'tracker_id' => $contract_tracker->id,
                    'log' => 'stop on ' . $string_end_date
                ]);
            }


            if($contract_tracker) return response()->json([
                'status' => true,
                'message' => 'Success Creating Tracker',
                'total_hours_cost' => $total_hours_cost,
                'total_hours' => $request->hours,
                'total_minutes' => $request->minutes,
                'start_time' => $contract_tracker->start_time,
                'stop_time' => $contract_tracker->end_time
            ]);

        }
    }

    public function create(Request $request) {
        if($request->type == 'proposal') {
            $data = ProjectProposal::where('id', $request->id)->with('project')->firstOrFail();
        }

        if($request->type == 'offer') {
            $data = ProjectOffer::where('id', $request->id)->firstOrFail();
        }

        $proposal_type = $request->type;

        return view('UserAuthScreens.contracts.create-contract', compact('data', 'proposal_type'));
    }

    public function store(StoreProjectContract $request) {
        try {
            $freelancer = Freelancer::where('id', $request->freelancer_id)->firstOrFail();
            $isNotAvailableDate = in_array($request->start_date, $freelancer->notAvailableDates()) || in_array($request->end_date, $freelancer->notAvailableDates()) ? back()->withErrors('Fail. The freelancer is not available on your expected start date') : true;

            #generate uuid
            $code = Str::random(10);
            DB::beginTransaction();

            #create project contract
            ProjectContract::create(array_merge($request->validated(), [
                'code' => $code,
                'status' => false,
            ]));

            #update project status
            Project::where('id', $request->project_id)->update([
                'status' => 'approved'
            ]);

            if($request->proposal_type == 'proposal') {
                #update project proposal status
                ProjectProposal::where('id', $request->proposal_id)->update([
                    'status' => 'approved'
                ]);
            }

            if($request->proposal_type == 'offer') {
                #update project offer status
                ProjectOffer::where('id', $request->proposal_id)->update([
                    'status' => 'approved'
                ]);
            }

            DB::commit();

            return redirect('/employer/projects/ongoing')->with('success', 'Success on creating contract');

        } catch (\ValidationException $e) {
            DB::rollback();
            throw $e;
        }
    }
}
