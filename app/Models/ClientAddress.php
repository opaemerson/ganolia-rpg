<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'street',
        'number',
        'complement',
        'district',
        'city',
        'state',
        'cep',
        'country',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
