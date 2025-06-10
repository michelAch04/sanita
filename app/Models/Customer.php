<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Customer extends Authenticatable
{
    use HasApiTokens, SoftDeletes, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'DOB',
        'mobile',
        'email',
        'gender',
        'email_verified_at',
        'token',
        'locked',
        'cancelled',
        'device_id',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'DOB',
        'email_verified_at',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function sendPasswordResetNotification($token)
    {
        $locale = app()->getLocale(); // Or use $this->locale if you store it per user
        // $this->notify(new \App\Notifications\ResetPasswordWithLocale($token, $locale));
    }
}
