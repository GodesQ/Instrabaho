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

    public function owner() {
        return $this->belongsTo(Employer::class, 'owner_id', 'id');
    }

    public function followers() {
        return $this->hasMany(Freelancer::class, 'id', 'follower_id');
    }
}
