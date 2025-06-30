<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    protected $fillable = [
        'products_id',
        'carts_id',
        'unit_price',
        'UOM',
        'shelf_price',
        'old_price',
        'extended_price',
        'quantity_ea',
        'canceled',
    ];

    // Add this relationship
    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id');
    }
}
