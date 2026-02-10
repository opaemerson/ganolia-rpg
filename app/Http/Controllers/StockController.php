<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Product;
use Illuminate\Http\Request;

class StockController 
{
    public function index()
    {
        $stocks = Stock::with('product')->get();

        return view('stock.index', compact('stocks'));
    }

    public function show($productId)
    {
        $stock = Stock::where('product_id', $productId)->firstOrFail();

        return view('stock.show', compact('stock'));
    }

    public function updateStock($productId, $quantityChange)
    {
        $stock = Stock::firstOrCreate(
            ['product_id' => $productId],
            ['quantity' => 0]
        );

        $stock->quantity += $quantityChange;

        if ($stock->quantity < 0) {
            $stock->quantity = 0;
        }

        $stock->save();

        return $stock;
    }
}
