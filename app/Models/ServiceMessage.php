<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceMessage extends Model
{
    use HasFactory;
    protected $table = 'service_messages';
    protected $guarded = []; 
}