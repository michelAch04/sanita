<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customers_id',
        'carts_id',
        'total_amount',
        'status',
        'payment_method',
        'shipping_address',
        'ordered_at',
        'cancelled',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customers_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
