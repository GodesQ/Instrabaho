<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardPayment extends Model
{
    use HasFactory;
    protected $table = 'app_card_payment';
    protected $guarded = [];

    protected $casts = [
        'payload' => 'array',
        'payment_attached' => 'array',
        'payment_attach_response' => 'array',
        'payment_method_response' => 'array',
        'payment_intent_response' => 'array',
        're_query_response' => 'array'
    ];
}
