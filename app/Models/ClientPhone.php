<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientPhone extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'phone',
        'label',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
