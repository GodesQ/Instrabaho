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

    protected $casts = ['user_id', 'hourly_rate'];

    protected $appends = ['rate', 'total_reviews', 'saved_project_ids'];

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

    public function saved_projects() {
        return $this->hasMany(SaveProject::class, 'follower_id');
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

        #sum of all rates
        $sum_rate = FreelancerReview::where('freelancer_id', $this->id)->sum('freelancer_rate');

        # total of reviews
        $total_of_reviews = $this->total_reviews();

        $average = $sum_rate == 0 ? 0 : $sum_rate / $total_of_reviews;

        $total_average = number_format($average, 1);
        return (float) number_format($total_average, 1);
    }

    public function total_reviews() {
        return FreelancerReview::where('freelancer_id', $this->id)->count();
    }

    public function getSavedProjectIdsAttribute() {
        return $this->saved_projects_ids();
    }

    public function saved_projects_ids() {
        $saved_projects = SaveProject::where('follower_id', $this->id)->get();
        $saved_project_ids = [];
        foreach ($saved_projects as $key => $saved_project) array_push($saved_project_ids, $saved_project->project_id);
        return $saved_project_ids;
    }

}
