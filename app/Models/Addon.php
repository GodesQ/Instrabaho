<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    use HasFactory;
    protected $table = 'addons';
    protected $guarded = [];

    public function freelancer() {
        return $this->belongsTo(Freelancer::class, 'user_role_id', 'id');
    }

}
