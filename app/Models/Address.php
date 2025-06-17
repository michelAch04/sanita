<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'title',
        'governorate_id',
        'district_id',
        'city_id',
        'street',
        'building',
        'floor',
        'notes',
        'is_default',
        'cancelled',
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
