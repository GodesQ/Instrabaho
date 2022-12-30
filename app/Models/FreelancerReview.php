<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreelancerReview extends Model
{
    use HasFactory;
    protected $table = 'freelancer_reviews';
    protected $guarded = [];
}
