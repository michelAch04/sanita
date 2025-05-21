<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    protected $fillable = [
        'product_id',
        'unit_price',
        'quantity',
    ];

    // In App\Models\CartDetail.php

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
