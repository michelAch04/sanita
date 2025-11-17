<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    protected $fillable = ['name_en', 'name_ar', 'name_ku', 'cancelled'];

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
