<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreelancerExperience extends Model
{
    use HasFactory;
    protected $table = 'freelancer_experiences';
    protected $guarded = []; 

    public function freelancer() {
        return $this->belongsTo(Freelancer::class);
    }
}