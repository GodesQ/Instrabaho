<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}