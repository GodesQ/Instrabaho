<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $guarded = [];

    protected $casts = [
        'source_callback_response' => 'array',
        'payment_response' => 'array',
        'payment_attach_response' => 'array'
    ];

    public function user_from() {
        return $this->belongsTo(User::class, 'from_id');
    }

    public function user_to() {
        return $this->belongsTo(User::class, 'to_id');
    }
}
