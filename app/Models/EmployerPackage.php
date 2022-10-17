<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployerPackage extends Model
{
    use HasFactory;
    protected $table = 'employer_packages';
    protected $guarded = []; 

    public function package_checkout() {
        return $this->belongsTo(PackageCheckout::class);
    }
}