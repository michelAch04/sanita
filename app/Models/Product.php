<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

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
        'subcategories_id',
        'brands_id',
        'unit_price',
        'available_quantity',
        'description',
        'small_description',
        'extension',
        'cancelled',
        'hidden',
    ];

    public function subcategories()
    {
        return $this->belongsTo(Subcategory::class, 'subcategories_id');
    }
    public function brands()
    {
        return $this->belongsTo(Brand::class, 'brands_id');
    }
}
