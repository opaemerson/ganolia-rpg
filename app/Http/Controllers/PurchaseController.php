<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseController
{
    public function index()
    {
        $purchases = Purchase::with('supplier')->paginate(10);
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $products  = Product::all();
        return view('purchases.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $purchase = Purchase::create([
            'supplier_id' => $request->supplier_id,
            'total'       => 0,
            'status'      => Purchase::STATUS_OPEN,
        ]);

        $total = 0;
        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);
            $subtotal = $item['quantity'] * $item['cost_price'];

            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'product_id'  => $product->id,
                'quantity'    => $item['quantity'],
                'cost_price'  => $item['cost_price'],
                'subtotal'    => $subtotal,
            ]);

            $total += $subtotal;
        }

        $purchase->update(['total' => $total]);

        return redirect()->route('purchases.show', $purchase->id)
                         ->with('success', 'Compra registrada com sucesso!');
    }

    public function show(Purchase $purchase)
    {
        $purchase->load('items.product', 'supplier');
        return view('purchases.show', compact('purchase'));
    }

    public function edit(Purchase $purchase)
    {
        $suppliers = \App\Models\Supplier::all();
        $products  = Product::all();
        $purchase->load('items');
        return view('purchases.edit', compact('purchase', 'suppliers', 'products'));
    }

    public function update(Request $request, Purchase $purchase)
    {
        if ($purchase->status !== Purchase::STATUS_OPEN) {
            return redirect()->back()->with('error', 'Não é possível editar uma compra confirmada ou cancelada.');
        }

        $purchase->items()->delete();

        $total = 0;
        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);
            $subtotal = $item['quantity'] * $item['cost_price'];

            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'product_id'  => $product->id,
                'quantity'    => $item['quantity'],
                'cost_price'  => $item['cost_price'],
                'subtotal'    => $subtotal,
            ]);

            $total += $subtotal;
        }

        $purchase->update([
            'supplier_id' => $request->supplier_id,
            'total'       => $total,
        ]);

        return redirect()->route('purchases.show', $purchase->id)
                         ->with('success', 'Compra atualizada com sucesso!');
    }

    public function destroy(Purchase $purchase)
    {
        if ($purchase->status === Purchase::STATUS_CONFIRMED) {
            return redirect()->back()->with('error', 'Não é possível excluir uma compra confirmada.');
        }

        $purchase->items()->delete();
        $purchase->delete();

        return redirect()->route('purchases.index')->with('success', 'Compra excluída com sucesso!');
    }

    public function confirm(Purchase $purchase)
    {
        if ($purchase->status !== Purchase::STATUS_OPEN) {
            return redirect()->back()->with('error', 'Compra já processada.');
        }

        foreach ($purchase->items as $item) {
            $stock = Stock::firstOrCreate(
                ['product_id' => $item->product_id],
                ['quantity' => 0]
            );

            $stock->quantity += $item->quantity;
            $stock->save();
        }

        $purchase->update(['status' => Purchase::STATUS_CONFIRMED]);

        return redirect()->route('purchases.show', $purchase->id)
                         ->with('success', 'Compra confirmada e estoque atualizado!');
    }

    public function cancel(Purchase $purchase)
    {
        if ($purchase->status !== Purchase::STATUS_OPEN) {
            return redirect()->back()->with('error', 'Compra já processada.');
        }

        $purchase->update(['status' => Purchase::STATUS_CANCELED]);

        return redirect()->route('purchases.show', $purchase->id)
                         ->with('success', 'Compra cancelada!');
    }
}
