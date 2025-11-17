<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'orders_id',
        'products_id',
        'unit_price',
        'shelf_price',
        'old_price',
        'extended_price',
        'quantity_primary',
        'quantity_foreign',
        'UOM',
        'statuses_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orders_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id');
    }
}
