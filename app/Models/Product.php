<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'barcode',
        'extension',
        'position',
        'name_en',
        'name_ar',
        'name_ku',
        'small_description_en',
        'small_description_ar',
        'small_description_ku',
        'ea_ca',
        'ea_pa',
        'product_line_code',
        'product_line_description',
        'family_code',
        'family_description',
        'subcategories_id',
        'brands_id',
        'tax_id',
        'hidden',
        'cancelled',
    ];

    public function subcategories()
    {
        return $this->belongsTo(Subcategory::class, 'subcategories_id');
    }

    public function brands()
    {
        return $this->belongsTo(Brand::class, 'brands_id');
    }

    public function listPrices()
    {
        return $this->hasMany(ListPrice::class, 'products_id');
    }

    public function distributorStocks()
    {
        return $this->hasMany(DistributorStock::class, 'products_id');
    }


    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brands_id');
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id');
    }
}
