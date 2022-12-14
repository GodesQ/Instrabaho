<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectContract extends Model
{
    use HasFactory;
    protected $table = 'project_contracts';
    protected $guarded = [];

    public function proposal() {
        return $this->hasOne(ProjectProposal::class, 'id', 'proposal_id');
    }

    public function offer() {
        return $this->hasOne(ProjectProposal::class, 'id', 'proposal_id');
    }

    public function project() {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public function tracker() {
        return $this->hasOne(ProjectContractTracker::class, 'contract_id');
    }

    public function freelancer() {
        return $this->hasOne(Freelancer::class, 'id', 'freelancer_id');
    }

    public function employer() {
        return $this->hasOne(Employer::class, 'id', 'employer_id');
    }
}
