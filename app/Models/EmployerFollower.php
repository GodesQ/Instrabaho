<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployerFollower extends Model
{
    use HasFactory;
    protected $table = 'employers_followers';
    protected $guarded = [];

    public function employer() {
        return $this->belongsTo(Employer::class, 'employer_id', 'id');
    }
}