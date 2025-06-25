<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name_en', 'name_ar', 'name_ku', 'districts_id', 'lat', 'long'];

    public function districts()
    {
        return $this->belongsTo(District::class);
    }
}
