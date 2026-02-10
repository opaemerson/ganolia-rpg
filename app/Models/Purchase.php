<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $table = 'purchases';

    protected $fillable = [
        'supplier_id',
        'total',
        'status',
    ];

    public const STATUS_OPEN      = 'Aberto';
    public const STATUS_CONFIRMED = 'Confirmado';
    public const STATUS_CANCELED  = 'Cancelado';

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }
}
