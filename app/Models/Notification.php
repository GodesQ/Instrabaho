<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $guarded = [];


    public function entity() {
        return $this->hasOne(EntityType::class, 'id', 'entity_type_id');
    }

    // public function getCreatedAtAttribute($date)
    // {
    //     return \Carbon\Carbon::parse('Y-m-d H:i:s', $date)->format('Y-m-d h:i:s');
    // }

    // public function getUpdatedAtAttribute($date)
    // {
    //     return \Carbon\Carbon::parse('Y-m-d H:i:s', $date)->format('Y-m-d h:i:s');
    // }
}
