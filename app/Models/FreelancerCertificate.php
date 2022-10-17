<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreelancerCertificate extends Model
{
    use HasFactory;
    protected $table = 'freelancer_certificates';
    protected $guarded = []; 

    public function freelancer() {
        return $this->belongsTo(Freelancer::class);
    }
}