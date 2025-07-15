<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCodeUsage extends Model
{
    use HasFactory;

    protected $fillable = ['promo_code_id', 'customer_id', 'count'];

    public function promoCode()
    {
        return $this->belongsTo(PromoCode::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
