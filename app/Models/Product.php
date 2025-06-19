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
        'name_en',
        'name_ar',
        'name_ku',
        'small_description_en',
        'small_description_ar',
        'small_description_ku',
        'position',
        'barcode',
        'old_price',
        'sku',
        'shelf_price',
        'threshold',
        'automatic_hide',
        'tax_id',
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

    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id');
    }
}
