<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EWalletPayment extends Model
{
    use HasFactory;
    protected $table = 'app_ewallet_payment';
    protected $guarded = [];

    protected $casts = [
        'payload' => 'array',
        'source_response' => 'array',
        'source_callback_response' => 'array',
        'payment_response' => 'array',
        're_query_response' => 'array'
    ];
}
