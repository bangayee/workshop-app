<?php

namespace App\Models;

use App\Models\PaymentTerm;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    // Specify the table name
    protected $table = 'transaction_payments';

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function payment_term()
    {
        return $this->belongsTo(PaymentTerm::class, 'payment_type');
    }
}
