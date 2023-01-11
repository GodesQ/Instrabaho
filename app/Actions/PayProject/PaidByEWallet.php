<?php

namespace App\Actions\PayProject;

use Illuminate\Support\Str;
use Carbon\Carbon;

// use App\Http\Requests\StoreNotification;
use Luigel\Paymongo\Facades\Paymongo;

use App\Models\Transaction;
use App\Models\EWalletPayment;
use App\Models\ProjectPayment;

class PaidByEWallet {

    public function action($project_contract = null, $request = null, $employer_total_cost = null, $total = null, $employer = null, $freelancer = null) {

        // Generate Transaction Code
        $transaction_code = 'TXN-ID' . '-' . strtoupper(Str::random(16));

        if($project_contract) {
            // Create Transaction Data
            $transaction = Transaction::create([
                'name_of_transaction' => $request->job_type == 'service' ? 'Pay Service' : 'Pay Project',
                'transaction_type' => 'pay_project',
                'transaction_code' => $transaction_code,
                'amount' => $employer_total_cost,
                'sub_amount' => $project_contract->total_cost,
                'from_id' => $employer->user_id,
                'to_id' => $freelancer->user_id,
                'payment_method' => $request->payment_method,
                'status' => 'initial'
            ]);

            // Create E-Wallet Payment Data
            $eWalletPayment = EWalletPayment::create([
                'user_id' => $employer->user_id,
                'transaction_code' => $transaction->transaction_code,
                'amount' => $employer_total_cost,
                'sub_amount' => $project_contract->total_cost,
                'type' => $request->payment_method,
                'status' => 'initial',
            ]);

            // Create Project Payment Data
            $project_payment = ProjectPayment::create([
                'user_id' => $employer->user_id,
                'contract_id' => $project_contract->id,
                'transaction_code' => $transaction->transaction_code,
                'employer_total' => $employer_total_cost,
                'freelancer_total' => $total,
            ]);
        }

        $payload = [
            'type' => $request->payment_method,
            'amount' => $employer_total_cost,
            'currency' => 'PHP',
            'redirect' => [
                'success' => route('ewallet.success', ['txn_code' => $transaction->transaction_code, 'type' => $request->job_type]),
                'failed' =>  route('ewallet.failed', ['txn_code' => $transaction->transaction_code, 'type' => $request->job_type]),
            ]
        ];

        $eWalletPayment->update([
            'payload' => $payload
        ]);

        $source = Paymongo::source()->create($payload);

        $eWalletPayment->update([
            'src_id' => $source->id,
            'source_response' => $source->getAttributes(),
            'status' => $source->status,
        ]);

        $transaction->update([
            'src_id' => $source->id,
            'status' => $source->status,
        ]);

        return redirect($source->redirect['checkout_url']);
    }
}
