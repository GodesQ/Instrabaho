<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = 'services';
    protected $guarded = [];

    public function freelancer() {
        return $this->belongsTo(Freelancer::class);
    }

    public function category() {
        return $this->hasOne(ServiceCategory::class, 'id', 'service_category');
    }

    public function purchase_services() {
        return $this->hasMany(PurchaseService::class, 'service_id');
    }
}