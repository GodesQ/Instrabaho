<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreelancePackage extends Model
{
    use HasFactory;
    protected $table = 'freelance_packages';
    protected $guarded = []; 

    public function package_checkout() {
        return $this->belongsTo(PackageCheckout::class);
    }
}