<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = ['categories_id', 'cancelled', 'name_en', 'name_ar', 'name_ku', 'hidden', 'extension'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }
}
