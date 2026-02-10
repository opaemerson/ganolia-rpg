<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController 
{
    public function index()
    {
        $sales = Sale::with('client')->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $clients  = \App\Models\Client::all();
        $products = Product::select('id','name','sale_price')->get();
        return view('sales.create', compact('clients', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'items'     => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($request) {
            $sale = Sale::create([
                'client_id' => $request->client_id,
                'total'     => 0,
                'status'    => Sale::STATUS_OPEN,
            ]);

            $total = 0;
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $price = $product->sale_price;
                $subtotal = $price * $item['quantity'];

                SaleItem::create([
                    'sale_id'    => $sale->id,
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'sale_price' => $price,
                ]);

                $total += $subtotal;
            }

            $sale->update(['total' => $total]);

            return redirect()->route('sales.show', $sale->id)
                             ->with('success', 'Venda criada com sucesso.');
        });
    }

    public function show(Sale $sale)
    {
        $sale->load('items.product', 'client');
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        if ($sale->status !== Sale::STATUS_OPEN) {
            return redirect()->back()->with('error', 'Somente vendas em Aberto podem ser editadas.');
        }

        $clients  = \App\Models\Client::all();
        $products = Product::select('id','name','sale_price')->get();
        $sale->load('items.product');

        return view('sales.edit', compact('sale', 'clients', 'products'));
    }

    public function update(Request $request, Sale $sale)
    {
        if ($sale->status !== Sale::STATUS_OPEN) {
            return redirect()->back()->with('error', 'Somente vendas em Aberto podem ser editadas.');
        }

        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'items'     => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($request, $sale) {
            $sale->items()->delete();

            $total = 0;
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $price = $product->sale_price;
                $subtotal = $price * $item['quantity'];

                SaleItem::create([
                    'sale_id'    => $sale->id,
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'sale_price' => $price,
                ]);

                $total += $subtotal;
            }

            $sale->update([
                'client_id' => $request->client_id,
                'total'     => $total,
            ]);

            return redirect()->route('sales.show', $sale->id)
                             ->with('success', 'Venda atualizada com sucesso.');
        });
    }

    public function destroy(Sale $sale)
    {
        if ($sale->status === Sale::STATUS_PAID) {
            return redirect()->back()->with('error', 'Não é possível excluir uma venda paga.');
        }

        if ($sale->status === Sale::STATUS_PAID) {
            return redirect()->back()->with('error', 'Venda já confirmada; cancele antes de excluir.');
        }

        $sale->items()->delete();
        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Venda excluída com sucesso.');
    }

    public function confirm(Sale $sale)
    {
        if ($sale->status !== Sale::STATUS_OPEN) {
            return redirect()->back()->with('error', 'Venda já processada.');
        }

        $sale->load('items');

        // checar estoque suficiente
        foreach ($sale->items as $item) {
            $stock = Stock::where('product_id', $item->product_id)->first();
            $available = $stock ? $stock->quantity : 0;
            if ($available < $item->quantity) {
                return redirect()->back()->with('error', "Estoque insuficiente para o produto ID {$item->product_id}.");
            }
        }

        DB::transaction(function () use ($sale) {
            foreach ($sale->items as $item) {
                $stock = Stock::firstOrCreate(['product_id' => $item->product_id], ['quantity' => 0]);
                $stock->quantity -= $item->quantity;
                if ($stock->quantity < 0) $stock->quantity = 0;
                $stock->save();
            }

            $sale->update(['status' => Sale::STATUS_PAID]);
        });

        return redirect()->route('sales.show', $sale->id)->with('success', 'Venda confirmada e estoque atualizado.');
    }

    public function cancel(Sale $sale)
    {
        if ($sale->status === Sale::STATUS_CANCELED) {
            return redirect()->back()->with('error', 'Venda já está cancelada.');
        }

        DB::transaction(function () use ($sale) {
            if ($sale->status === Sale::STATUS_PAID) {
                // restaurar estoque
                foreach ($sale->items as $item) {
                    $stock = Stock::firstOrCreate(['product_id' => $item->product_id], ['quantity' => 0]);
                    $stock->quantity += $item->quantity;
                    $stock->save();
                }
            }

            $sale->update(['status' => Sale::STATUS_CANCELED]);
        });

        return redirect()->route('sales.show', $sale->id)->with('success', 'Venda cancelada.');
    }
}
