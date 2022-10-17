<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaveProject extends Model
{
    use HasFactory;
    protected $table = 'saved_projects';
    protected $guarded = [];

    public function project() {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}