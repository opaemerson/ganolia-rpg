<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProfileFunctionality extends Pivot
{
    protected $table = 'profile_functionalities';

    protected $fillable = [
        'profile_id',
        'functionality_id',
    ];
}
