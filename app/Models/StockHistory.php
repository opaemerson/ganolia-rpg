<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockHistory extends Model
{
    use HasFactory;

    protected $table = 'stock_history';

    protected $fillable = [
        'product_id',
        'type',
        'quantity',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public const TYPES = [
        'entry',
        'exit',
        'sale',
        'loss',
        'adjustment',
    ];
}
