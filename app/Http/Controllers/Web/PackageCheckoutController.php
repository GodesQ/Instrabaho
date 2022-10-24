<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\PackageCheckout;
use App\Models\FreelancePackage;
use App\Models\EmployerPackage;
use App\Models\Freelancer;
use App\Models\Employer;
use App\Models\UserWallet;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Invoice;
use App\Models\InvoiceItem;

class PackageCheckoutController extends Controller
{
    public function package_checkout(Request $request) {
        $package_model = session()->get('role') == 'freelancer' ? FreelancePackage::class : EmployerPackage::class;
        $package = $package_model::where('id', $request->package_id)->first();
        $user_id = session()->get('id');
        $user_model = session()->get('role') == 'freelancer' ? Freelancer::class : Employer::class;
        $user = $user_model::where('user_id', $user_id)->with('user')->first();
        return view('packages.package-form', compact('user', 'package'));
    }

    public function store_package_checkout(Request $request) {
        $request->validate([
            "complete_address" => 'required',
        ]);

        // Check if the current package is expired
        $model = session()->get('role') == 'freelancer' ? Freelancer::class : Employer::class;
        $user = $model::where('user_id', session()->get('id'))->first();
        $userPackageCheckout = PackageCheckout::where('id', $user->package_checkout_id)->first();
        
        if($userPackageCheckout) {
            if(!$userPackageCheckout->isExpired) return back()->with('fail', 'Your Current Plan is not expired. Please wait to expire to purchase again.');
        }

        switch ($request->payment_type) {
            case 'paid_by_wallet':
                return $this->PaidByWallet($request->all());
            case 'test':
                $data = $request->except('_token', 'package_id', 'latitude', 'longitude');
                $checkout_id = PackageCheckout::insertGetId($data);
                PackageCheckout::where('id', $checkout_id)->update([
                    'created_at' => Carbon::now()
                ]);
                    /* Get the date expiration based on the package of user */
                    $package = session()->get('role') == 'freelancer' ? FreelancePackage::where('id', $request->package_type)->first() : EmployerPackage::where('id', $request->package_type)->first();;
                    $date_expiration = Carbon::now()->addDays($package->expiry_days);
                    
                    /* Once we have a date expiration of package, update user package_checkout_id & package_date_expiration column */
                    $model = session()->get('role') == 'freelancer' ? Freelancer::class : Employer::class;
                    $user_update = $model::where('id', $request->user_role_id)->update([
                        'package_checkout_id' => $checkout_id,
                        'package_date_expiration' => $date_expiration
                    ]);
                return redirect('/dashboard')->with('success', 'Plan Added Successfully');

            case 'gcash':
                return back();
            
        }
    }

    private function PaidByWallet($data) {
        $package_checkout_data = $data;
        $user_wallet = UserWallet::where('user_id', session()->get('id'))->first();
        
        $remove_values = ['_token', 'longitude', 'latitude', 'package_id'];
        foreach ($remove_values as $key => $value) {
            unset($package_checkout_data[$value]);
        }

        // store packagecheckout in database
        $checkout_id = PackageCheckout::insertGetId($package_checkout_data);
        // update the date of packagecheckout
        PackageCheckout::where('id', $checkout_id)->update([
            'created_at' => Carbon::now()
        ]);

        /* Get the date expiration based on the package of user */
        $package = session()->get('role') == 'freelancer' ? FreelancePackage::where('id', $data['package_type'])->first() : EmployerPackage::where('id', $data['package_type'])->first();;
        $date_expiration = Carbon::now()->addDays($package->expiry_days);
        
        /* Once we have a date expiration of package, update user package_checkout_id & package_date_expiration column */
        $model = session()->get('role') == 'freelancer' ? Freelancer::class : Employer::class;
        $user_update = $model::where('id', $data['user_role_id'])->update([
            'package_checkout_id' => $checkout_id,
            'package_date_expiration' => $date_expiration
        ]);

        if($user_update && $checkout_id) {
            // Generate Transaction Code
            $transaction_code = strtoupper(Str::random(8));

            // Create Transaction
            $create_transaction = Transaction::create([
                'name_of_transaction' => 'Buy Package',
                'transaction_code' => $transaction_code,
                'amount' => $package->price,
                'from_id' => 0,
                'to_id' => session()->get('id'),
                'payment_method' => 'paid_by_wallet',
                'status' => 'success'
            ]);

            // Generate Invoice Code
            $invoice_code = strtoupper(Str::random(8));

            // Create Invoice
            $invoice = Invoice::create([
                'invoice_name' => 'Buy Package',
                'date_issue' => Carbon::now(),
                'due_date' => Carbon::now()->addDays(5),
                'invoice_code' => $invoice_code,
                'bill_from' => 0,
                'bill_to' => session()->get('id'),
                'payment_method' => 'paid_by_wallet',
                'invoice_date' => Carbon::now(),
            ])->id;
            
            // Create Invoice Item
            $create_invoice_item = InvoiceItem::create([
                'invoice_id' => $invoice,
                'item' => session()->get('role') == 'freelancer' ? "Buy $package->name Package for Freelancer" : "Buy $package->name Package for Employer",
                'quantity' => 1,
                'amount' => $package->price,
            ]);

            if(!$user_wallet) {
                return back()->with('fail', "Your Wallet doesn't exists. Create Your Wallet First before sending a transaction. Thankyou.");
            } else {
                $create_wallet = UserWallet::where('user_id', $user_wallet->user_id)->update([
                    'amount' => $user_wallet->amount - $package->price,
                ]);
            }

            return redirect('/transaction-message')->with('success', 'Package Successfully Added');
        }



    }

    public function employer_package_checkout(Request $request) {
        $package = EmployerPackage::where('id', $request->package_id)->first();
        $user_id = session()->get('id');
        $user = Employer::where('user_id', $user_id)->with('user')->first();
        return view('packages.package-form', compact('user', 'package'));
    }
}