<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageCheckout extends Model
{
    use HasFactory;
    protected $table = 'package_checkouts';
    protected $guarded = []; 

    public function freelancer() {
        return $this->belongsTo(Freelancer::class);
    }

    public function employer() {
        return $this->belongsTo(Employer::class);
    }

    public function freelance_package() {
        return $this->hasOne(FreelancePackage::class, 'id', 'package_type');
    }

    public function employer_package() {
        return $this->hasOne(FreelancePackage::class, 'id', 'package_type');
    }
}