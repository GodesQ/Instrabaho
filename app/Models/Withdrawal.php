<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;
    protected $table = 'withdrawals';
    protected $guarded = [];

    protected $appends = ['type_data'];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function transaction() {
        return $this->hasOne(Transaction::class, 'id', 'txn_id');
    }

    public function getTypeDataAttribute() {
        return $this->withdrawal_type_data();
    }

    public function withdrawal_type_data() {
        $withdrawal_type = $this->withdrawal_type;
        if($withdrawal_type == 'gcash') {
            return $this->gcash_type_withdrawal();
        }

        if($withdrawal_type == 'card') {
            return $this->card_type_withdrawal();
        }
    }

    public function gcash_type_withdrawal() {
        $data = GcashWithdrawal::where('withdrawal_id', $this->id)->first();
        return $data;
    }

    public function card_type_withdrawal() {
        $data = CardWithdrawal::where('withdrawal_id', $this->id)->first();
        return $data;
    }
}
