<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'cart_detail_id',
        'expires_at',
        'purchased',
        'locked',
        'cancelled',
        'delivery_charge',
        'promocode',

    ];
    public function cartDetails()
    {
        return $this->hasMany(CartDetail::class);
    }

    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
