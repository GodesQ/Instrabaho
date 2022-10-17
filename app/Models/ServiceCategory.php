<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use HasFactory;
    protected $table = 'services_categories';
    protected $guarded = [];

    public function services() {
        return $this->belongsTo(Service::class);
    }

    public function projects() {
        return $this->hasMany(Project::class);
    }
}