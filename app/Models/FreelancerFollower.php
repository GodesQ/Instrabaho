<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreelancerFollower extends Model
{
    use HasFactory;
    protected $table = 'freelancers_followers';
    protected $guarded = [];

    public function freelancer() {
        return $this->belongsTo(Freelancer::class, 'freelancer_id', 'id');
    }

    public function followers() {
        return $this->hasMany(Employer::class, 'id', 'follower_id');
    }
}
