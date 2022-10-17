<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Crazymeeks\Foundation\PaymentGateway\Dragonpay;

use App\Models\ServicesProposal;
use App\Models\ProjectProposal;

class TransactionsController extends Controller
{
    public function transaction_messaage(Request $request) {
        return redirect('/transaction-postback');
        return view('misc.transaction-message');
    }

    public function postback_transaction(Request $request) {
        
    }

    public function pay_job(Request $request) {
        if(!$request->type || !$request->id) return view('fail', 'Fail to direct in payment section');

        //check what type of job 
        if($request->type == 'service') {
            $job = ServicesProposal::where('id', $request->id)->with('service', 'freelancer', 'employer')->first();
            $job_data = [
                'title' => $job->service->name,
                'cost' => $job->service->cost,
            ];
        }

        if($request->type == 'project') {

        }
        dd($job_data);

        return view('checkout.pay-job', compact('job_data'));
    }
}