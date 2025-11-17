<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributorStock extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'products_id',
        'distributors_id',
        'stock',
    ];


    public function distributor()
    {
        return $this->belongsTo(Distributor::class, 'distributors_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id');
    }
}
