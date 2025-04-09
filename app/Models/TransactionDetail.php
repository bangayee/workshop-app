<?php

namespace App\Models;

use App\Models\Supplier;
use App\Models\Attribute;
use Illuminate\Database\Eloquent\Model;
use App\Models\TransactionDetailProduct;
use App\Models\TransactionDetailProductSupplier;

class TransactionDetail extends Model
{
    public function product_transaction()
    {
        return $this->hasMany(TransactionDetailProduct::class, 'detail_id');
    }

    public function product_transaction_supplier()
    {
        return $this->hasMany(TransactionDetailProductSupplier::class, 'detail_product_id');
        // return $this->hasMany(TransactionDetailProductSupplier::class, 'detail_product_id',
        // function (Builder $query) {
        //     $query->join('suppliers', 'suppliers.id', '=', 'transaction_detail_product_suppliers.supplier_id');
        // });

        // $posts = Post::whereHas('comments', function (Builder $query) {
        //     $query->where('content', 'like', 'code%');
        // })->get();

    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    // public function attribute()
    // {
    //     return $this->belongsTo(Attribute::class, 'attribute_id');
    // }
}
// join('suppliers', 'suppliers.id', '=', 'transaction_detail_product_suppliers.supplier_id')