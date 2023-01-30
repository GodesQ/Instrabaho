<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Project extends Model
{
    use HasFactory;
    protected $table = 'projects';
    protected $guarded = [];

    protected $appends = ['project_skills'];

    protected $casts = [
        'employer_id' => 'integer',
        'cost' => 'integer',
        'category_id' => 'integer',
        'total_cost' => 'integer',
        'total_dates' => 'integer',
        'skills' => 'array'
    ];

    public function scopeCompleted($query) {
        return $query->where('status', 'completed');
    }

    public function scopeApproved($query) {
        return $query->where('status', 'approved');
    }

    public function scopePending($query) {
        return $query->where('status', 'pending');
    }

    public function employer() {
        return $this->belongsTo(Employer::class);
    }

    public function category() {
        return $this->hasOne(ServiceCategory::class, 'id', 'category_id');
    }

    public function contract() {
        return $this->hasOne(ProjectContract::class, 'project_id', 'id');
    }

    // public function skills() {
    //     return $this->belongsToMany(Skill::class, 'skills');
    // }

    public function getProjectSkillsAttribute()
    {
        return $this->project_skills();
    }

    public function project_skills() {
        $skills = Skill::whereIn('id', $this->skills)->get();
        return $skills;
    }

    public function scopeBestResult($query, $value) {

    }
}
