<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectContractTracker extends Model
{
    use HasFactory;
    protected $table = 'project_contract_tracker';
    protected $guarded = [];

    public function tracker_logs() {
        return $this->hasMany(ProjectContractTrackerLog::class, 'tracker_id');
    }
}
