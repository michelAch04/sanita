<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'role',
        'add',
        'edit',
        'delete',
        'view',
        'excel',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class, 'pages_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
