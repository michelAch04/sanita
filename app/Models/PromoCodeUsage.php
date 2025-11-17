<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCodeUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'promo_codes_id',   // renamed to match your controller
        'customers_id',     // renamed to match your controller
        'count',
    ];

    public function promoCode()
    {
        return $this->belongsTo(PromoCode::class, 'promo_codes_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customers_id');
    }
}
