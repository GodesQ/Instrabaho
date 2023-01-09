<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTrackerLog extends Model
{
    use HasFactory;
    protected $table = 'project_contract_tracker_log';
    protected $guarded = [];
}
