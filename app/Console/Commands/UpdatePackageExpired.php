<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Freelancer;
use App\Models\Employer;
use App\Models\PackageCheckout;
use Carbon\Carbon;

class UpdatePackageExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily_update:package_expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily Update of Package Expiration';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::now('Asia/Manila');
        $freelancers = Freelancer::whereDate('package_date_expiration', '<=', $today)->with('package_checkout')->get();

        foreach ($freelancers as $key => $freelancer) {
           $freelancer->package_checkout()->update([
                'isExpired' => 1,
           ]);
        }

        $employers = Employer::whereDate('package_date_expiration', '<=', $today)->with('package_checkout')->get();
        foreach ($employers as $key => $employer) {
            $employer->package_checkout()->update([
                 'isExpired' => 1,
            ]);
         }
    }
}