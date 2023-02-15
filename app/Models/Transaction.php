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

    public function create_transaction($request, $transaction_code, $user, $to_user_id, $amount, $title, $transaction_type) {
        return Transaction::create([
            'name_of_transaction' => $title,
            'transaction_type' => $transaction_type,
            'transaction_code' => $transaction_code,
            'amount' => $amount,
            'sub_amount' => $amount,
            'from_id' => $user->id,
            'to_id' => $to_user_id,
            'payment_method' => $request->payment_method,
            'status' => 'initial'
        ]);
    }
}
