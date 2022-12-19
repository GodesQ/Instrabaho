<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Freelancer extends Model
{
    use HasFactory;
    protected $table = 'user_freelancer';
    protected $guarded = [];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function package_checkout() {
        return $this->hasOne(PackageCheckout::class, 'id', 'package_checkout_id');
    }

    public function certificates() {
        return $this->hasMany(FreelancerCertificate::class, 'freelancer_id');
    }

    public function experiences() {
        return $this->hasMany(FreelancerExperience::class, 'freelancer_id');
    }

    public function educations() {
        return $this->hasMany(FreelancerEducation::class, 'freelancer_id');
    }

    public function skills() {
        return $this->hasMany(FreelancerSkill::class, 'freelancer_id');
    }

    public function services() {
        return $this->hasMany(Service::class, 'freelancer_id');
    }

    public function project_proposals() {
        return $this->hasMany(ProjectProposal::class, 'freelancer_id');
    }

    public function project_offers() {
        return $this->hasMany(ProjectOffer::class, 'freelancer_id');
    }

    public function notAvailableDates() {
        $allNotAvailableDates = array();

        $contracts = ProjectContract::where('freelancer_id', $this->id)->with('project', 'proposal')->whereHas('project', function($q) {
            return $q->where('status', '!=', 'cancel')->orWhere('status', '!=', 'pending');
        })->get();

        foreach ($contracts as $key => $contract) {

            # first we will transfer to array of dates
            $periods = new \DatePeriod(
                new \DateTime($contract->start_date),
                new \DateInterval('P1D'),
                new \DateTime($contract->end_date . '+1 day'),
           );

           foreach ($periods as $key => $date) {
                $allNotAvailableDates[] = $date->format('Y-m-d');
           }

        }

        return $allNotAvailableDates;

    }

}
