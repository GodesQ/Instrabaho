<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;
    protected $table = 'user_employer';
    protected $guarded = []; 

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function package_checkout() {
        return $this->hasOne(PackageCheckout::class, 'id', 'package_checkout_id');
    }

    public function projects() {
        return $this->hasMany(Project::class, 'employer_id');
    }
}