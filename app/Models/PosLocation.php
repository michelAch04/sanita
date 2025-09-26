<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosLocation extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'cities_id',
        'phone',
        'latitude',
        'longitude',
        'type',
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'cities_id');
    }
}
