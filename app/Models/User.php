<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;
    protected $table = 'user';
    protected $guarded = [];
    protected $hidden = ['password', 'isVerify'];

    public function freelancer() {
        return $this->belongsTo(Freelancer::class);
    }

    public function employer() {
        return $this->belongsTo(Employer::class);
    }

    public function wallet() {
        return $this->hasOne(UserWallet::class, 'user_id', 'id');
    }
}
