<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\Workflow;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function workflow()
    {
        return $this->belongsTo(Workflow::class, 'order_status');
    }


}
