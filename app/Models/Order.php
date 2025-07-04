<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customers_id',
        'carts_id',
        'distributors_id',
        'addresses_id',
        'subtotal_amount',
        'tax_amount',
        'total_amount',
        'statuses_id',
        'payment_method',
        'cancelled',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customers_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'orders_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'addresses_id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'statuses_id');  
    }

}
