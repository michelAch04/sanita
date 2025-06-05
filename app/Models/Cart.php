<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'customers_id',
        'expires_at',
        'purchased',
        'locked',
        'cancelled',
        'delivery_charge',
        'promocode',
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
