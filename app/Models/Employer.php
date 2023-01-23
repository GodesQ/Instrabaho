<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;
    protected $table = 'user_employer';
    protected $guarded = [];

    protected $appends = ['rate', 'total_reviews'];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function package_checkout() {
        return $this->hasOne(PackageCheckout::class, 'id', 'package_checkout_id');
    }

    public function projects() {
        return $this->hasMany(Project::class, 'employer_id');
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
        $sum_rate = EmployerReview::where('employer_id', $this->id)->sum('employer_rate');
        # total of reviews
        $total_of_reviews = EmployerReview::where('employer_id', $this->id)->count();

        $average = $sum_rate == 0 ? 0 : $sum_rate / $total_of_reviews;

        $total_average = number_format($average, 1);
        return (float) number_format($total_average, 1);
    }

    public function total_reviews() {
        return EmployerReview::where('employer_id', $this->id)->count();
    }
}
