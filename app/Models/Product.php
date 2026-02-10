<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'category_id',
        'cost_price',
        'sale_price',
    ];

    public function category() { 
        return $this->belongsTo(Category::class); 
    }
}
