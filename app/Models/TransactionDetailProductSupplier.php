<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetailProductSupplier extends Model
{
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function workflow()
    {
        return $this->belongsTo(Workflow::class, 'process_status');
    }

    public function detail_product()
    {
        return $this->belongsTo(TransactionDetail::class, 'detail_product_id');
    }

}
