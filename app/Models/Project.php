<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table = 'projects';
    protected $guarded = [];


    public function getSkills() {
        return $this->skills_name;
    }

    public function setSkills($value) {
        $skills = Skill::whereIn('id', $value)->get('skill_name');
        return $this->skills_name = $skills;
    }

    // public function freelancer() {
    //     return $this->belongsTo(Freelancer::class);
    // }

    public function employer() {
        return $this->belongsTo(Employer::class);
    }

    public function category() {
        return $this->hasOne(ServiceCategory::class, 'id', 'category_id');
    }

    public function contract() {
        return $this->hasOne(ProjectContract::class, 'project_id', 'id');
    }

}
