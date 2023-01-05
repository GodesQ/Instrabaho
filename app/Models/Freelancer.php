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

    protected $casts = [
        'user_id' => 'integer',
        'hourly_rate' => 'integer',
    ];

    protected $appends = ['rate', 'total_reviews'];

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

    public function projects() {
        return $this->hasMany(FreelancerProject::class, 'freelancer_id');
    }

    public function freelancer_skills() {
        return $this->hasManyThrough(
            Skill::class,
            FreelancerSkill::class,
            'freelancer_id',
            'id',
        );
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

    public function projects_completed() {
        return $this->hasMany(ProjectContract::class, 'freelancer_id')->where('status', 1);
    }

    public function notAvailableDates() {
        $allNotAvailableDates = array();

        $contracts = ProjectContract::where('freelancer_id', $this->id)->with('project', 'proposal')->whereHas('project', function($q) {
            return $q->where('status', '!=', 'cancel')->orWhere('status', '!=', 'pending');
        });

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

    public function getRateAttribute()
    {
        return $this->rate();
    }

    public function getTotalReviewsAttribute() {
        return $this->total_reviews();
    }

    public function rate() {
        $one_rates = FreelancerReview::where('freelancer_id', $this->id)->where('freelancer_rate', 1)->count();
        $two_rates = FreelancerReview::where('freelancer_id', $this->id)->where('freelancer_rate', 2)->count();
        $three_rates = FreelancerReview::where('freelancer_id', $this->id)->where('freelancer_rate', 3)->count();
        $four_rates = FreelancerReview::where('freelancer_id', $this->id)->where('freelancer_rate', 4)->count();
        $five_rates = FreelancerReview::where('freelancer_id', $this->id)->where('freelancer_rate', 5)->count();

        $sub_average = $five_rates + $four_rates + $three_rates + $two_rates + $one_rates;
        $average = $sub_average == 0 ? 0 : (5 * $five_rates + 4 * $four_rates + 3 * $three_rates + 2 * $two_rates + 1 * $one_rates) / $sub_average;
        $total_average = number_format($average, 1);

        return (float) number_format($total_average, 1);
    }

    public function total_reviews() {
        return FreelancerReview::where('freelancer_id', $this->id)->count();
    }

}
