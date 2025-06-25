<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = ['name_en', 'name_ar', 'name_ku', 'governorates_id', 'lat', 'long'];

    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
