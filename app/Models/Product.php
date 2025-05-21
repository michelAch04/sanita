<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'sku',
        'shelf_price',
        'threshold',
        'automatic_hide',
        'tax',
        'subcategory_id',
        'brand_id',
        'unit_price',
        'available_quantity',
        'description',
        'small_description',
        'extension',
        'cancelled',
        'hidden',
    ];
}
