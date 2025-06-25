<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributorAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'cities_id',
        'distributors_id',
    ];
}
