<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreelancerSkill extends Model
{
    use HasFactory;
    protected $table = 'freelancer_skills';
    protected $guarded = []; 

    public function skill() {
        return $this->hasOne(Skill::class, 'id', 'skill_id');
    }
}