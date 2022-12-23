<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectContract extends Model
{
    use HasFactory;
    protected $table = 'project_contracts';
    protected $fillable = ['project_id', 'proposal_id', 'freelancer_id', 'employer_id', 'start_date', 'end_date', 'cost', 'code', 'is_verify_cde', 'status'];

    public function proposal() {
        return $this->hasOne(ProjectProposal::class, 'id', 'proposal_id');
    }

    public function project() {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

}
