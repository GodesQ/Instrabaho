<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Freelancer;

class SaveProject extends Model
{
    use HasFactory;
    protected $table = 'saved_projects';
    protected $guarded = [];

    public function project() {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public function owner() {
        return $this->belongsTo(Employer::class, 'owner_id', 'id');
    }

    public function followers() {
        return $this->hasMany(Freelancer::class, 'id', 'follower_id');
    }

    public function scopeGetAllFollowers($query, $id) {
        return SaveProject::where('project_id', $id)->with('followers');
    }
}
