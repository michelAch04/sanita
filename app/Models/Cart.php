<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'customers_id',
        'total_amount',
        'subtotal_amount',
        'tax_amount',
    ];
    public function cartDetails()
    {
        return $this->hasMany(CartDetail::class, 'carts_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customers_id');
    }
}
