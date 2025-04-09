<?php

namespace App\Models;

use App\Models\PaymentTerm;
use Illuminate\Database\Eloquent\Model;

class TransactionPayment extends Model
{
    public function payment_terms()
    {
        return $this->belongsTo(PaymentTerm::class, 'payment_type');
    }
}
