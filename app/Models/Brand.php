<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name_en',
        'name_ar',
        'name_ku',
        'hidden',
        'extension',
        'cancelled',
        'created_at',
        'updated_at',
    ];
}
