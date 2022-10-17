<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicesProposal extends Model
{
    use HasFactory;
    protected $table = 'services_proposal';
    protected $guarded = [];

    public function service() {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function employer() {
        return $this->belongsTo(Employer::class, 'buyer_id', 'id');
    }

    public function freelancer() {
        return $this->belongsTo(Freelancer::class, 'seller_id', 'id');
    }
}