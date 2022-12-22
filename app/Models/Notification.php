<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $guarded = [];

    public function entity() {
        return $this->hasOne(EntityType::class, 'id', 'entity_type_id');
    }
}
