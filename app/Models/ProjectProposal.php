<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectProposal extends Model
{
    use HasFactory;
    protected $table = 'project_proposals';
    protected $guarded = [];

    public function employer() {
        return $this->belongsTo(Employer::class, 'employer_id', 'id');
    }

    public function freelancer() {
        return $this->belongsTo(Freelancer::class, 'freelancer_id', 'id');
    }

    public function project() {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function contract() {
        return $this->belongsTo(ProjectContract::class, 'id', 'proposal_id');
    }
}