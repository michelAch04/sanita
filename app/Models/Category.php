<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name_en', 'name_ar', 'name_ku', 'extension', 'hidden', 'cancelled'];

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }
}
