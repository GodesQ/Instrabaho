<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Admin extends Authenticatable
{
    use HasFactory;
    protected  $table = 'admin';
    protected $fillable = ['username', 'email', 'is_twoauth', 'password', 'is_active', 'role', 'is_deleted', 'created_at', 'updated_at'];
    protected $hidden = ['password'];
    protected $guarded = ['password'];
}
