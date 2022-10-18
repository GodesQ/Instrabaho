<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

    public function employer_package_checkout(Request $request) {
        $package = EmployerPackage::where('id', $request->package_id)->first();
        $user_id = session()->get('id');
        $user = Employer::where('user_id', $user_id)->with('user')->first();
        return view('packages.package-form', compact('user', 'package'));
    }
}