<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardWithdrawal extends Model
{
    use HasFactory;
    protected $table = 'card_withdrawals';
    protected $guarded = [];
}
