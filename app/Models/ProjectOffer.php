<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectOffer extends Model
{
    use HasFactory;
    protected $table = 'projects_offer';
    protected $guarded = [];

    public function project() {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public function freelancer() {
        return $this->hasOne(Freelancer::class, 'id', 'freelancer_id');
    }

    public function employer() {
        return $this->hasOne(Employer::class, 'id', 'employer_id');
    }

    public function contract() {
        return $this->belongsTo(ProjectContract::class, 'id', 'proposal_id');
    }

}
