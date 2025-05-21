<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'cancelled',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function permission()
    {
        return $this->hasOne(Permission::class, 'user_id', 'id');
    }
}
