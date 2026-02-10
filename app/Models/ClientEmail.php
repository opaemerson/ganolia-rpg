<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'email',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
