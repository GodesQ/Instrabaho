<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreelancerProject extends Model
{
    use HasFactory;
    protected $table = 'freelancer_projects';
    public $timestamps = false;
    protected $guarded = []; 
}