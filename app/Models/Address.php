<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'customers_id',
        'title',
        'governorates_id',
        'districts_id',
        'cities_id',
        'street',
        'building',
        'floor',
        'notes',
        'is_default',
        'cancelled',
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customers_id');
    }

    public function governorate()
    {
        return $this->belongsTo(Governorate::class, 'governorates_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'districts_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'cities_id');
    }
}
