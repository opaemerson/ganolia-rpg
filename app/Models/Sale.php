<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';

    protected $fillable = [
        'client_id',
        'total',
        'status',
    ];

    public const STATUS_OPEN     = 'Aberto';
    public const STATUS_PAID     = 'Pago';
    public const STATUS_CANCELED = 'Cancelado';

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}
