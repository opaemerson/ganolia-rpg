<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'profile_id',
        'login',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
