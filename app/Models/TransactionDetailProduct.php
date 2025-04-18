<?php

namespace App\Models;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionDetailProduct extends Model
{
    use HasFactory;

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attributes_id');
    }

    // public function supplier()
    // {
    //     return $this->belongsTo(Supplier::class, 'supplier_id');
    // }
}
