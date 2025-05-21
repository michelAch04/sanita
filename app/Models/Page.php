<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'url',
        'permission_id',
    ];

    /**
     * Define the relationship with the Permission model.
     */
    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
