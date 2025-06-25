<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'products_id',
        'type',
        'unit_price',
        'shelf_price',
        'old_price',
        'min_quantity_to_order',
        'max_quantity_to_order',
        'trade_loader',
        'trade_loader_quantity',
        'UOM',
        'EA',
        'CA',
        'PL',
        'hidden',
        'automatic_hide',
        'cancelled',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id');
    }
}
