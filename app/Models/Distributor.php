<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'location',
    ];

    public function stocks()
    {
        return $this->hasMany(DistributorStock::class, 'distributors_id');
    }

    public function addresses()
    {
        return $this->hasMany(DistributorAddress::class, 'distributors_id');
    }
}
