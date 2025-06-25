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
        'country_code',
        'email',
        'gender',
        'verified_at',
        'token',
        'locked',
        'cancelled',
        'device_id',
        'password',
        'otp',
        'otp_expires_at',
        'type',
        'verified',
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

    public function addresses()
    {
        return $this->hasMany(\App\Models\Address::class, 'customers_id');
    }

    public function sendPasswordResetNotification($token)
    {
        $locale = app()->getLocale();
        $this->notify(new \App\Notifications\ResetPasswordWithLocale($token, $locale));
    }
}
