<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreelancerEducation extends Model
{
    use HasFactory;
    protected $table = 'freelancer_education';
    protected $guarded = []; 

    public function freelancer() {
        return $this->belongsTo(Freelancer::class);
    }
}