<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected  $table = 'admin';
    protected $fillable = ['username', 'email', 'is_twoauth', 'is_active', 'is_deleted', 'created_at', 'updated_at'];
    protected $guarded = ['password'];
}