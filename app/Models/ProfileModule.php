<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProfileModule extends Pivot
{
    protected $table = 'profiles_modules';

    protected $fillable = [
        'profile_id',
        'module_id',
    ];
}
