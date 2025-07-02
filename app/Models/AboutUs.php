<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'textarea_en',
        'textarea_ar',
        'textarea_ku',
    ];
}
