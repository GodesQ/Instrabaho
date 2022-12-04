<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectContract extends Model
{
    use HasFactory;
    protected $table = 'project_contracts';
    protected $fillable = ['project_id', 'proposal_id', 'freelancer_id', 'employer_id', 'start_date', 'end_date', 'cost'];

    public function proposal() {
        return $this->hasOne(ProjectProposal::class, 'id', 'proposal_id');
    }

}
