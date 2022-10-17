<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoices';
    protected $guarded = [];

    public function invoice_items() {
        return $this->hasMany(InvoiceItem::class, 'invoice_id', 'id');
    }
}