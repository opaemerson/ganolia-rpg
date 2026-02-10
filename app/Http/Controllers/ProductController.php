<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Product;
use App\Models\Category;

class ProductController 
{
    public function index(Request $request)
    {
        $search = $request->get('q');
        $products = Product::with('category')
            ->when($search, fn($qry) => $qry->where('name', 'like', "%{$search}%"))
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('register.list-product', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('register.create-product', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:products,name',
            'category_id' => 'required|exists:categories,id',
        ]);

        $cost = str_replace(',', '.', str_replace('.', '', $request->input('cost_price', '')));
        $sale = str_replace(',', '.', str_replace('.', '', $request->input('sale_price', '')));

        if (!is_numeric($cost) || !is_numeric($sale)) {
            return redirect()->back()->withErrors(['cost_price' => 'Preços inválidos'])->withInput();
        }

        Product::create([
            'name' => $request->input('name'),
            'category_id' => $request->input('category_id'),
            'cost_price' => number_format((float)$cost, 2, '.', ''),
            'sale_price' => number_format((float)$sale, 2, '.', ''),
        ]);

        return redirect()->route('products.index')->with('success', 'Produto criado com sucesso.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('register.edit-product', compact('product', 'categories'));
    }


    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => ['required','string','max:255', Rule::unique('products', 'name')->ignore($product->id)],
            'category_id' => 'required|exists:categories,id',
        ]);

        $cost = str_replace(',', '.', str_replace('.', '', $request->input('cost_price', '')));
        $sale = str_replace(',', '.', str_replace('.', '', $request->input('sale_price', '')));

        if (!is_numeric($cost) || !is_numeric($sale) || $cost < 0 || $sale < 0) {
            return redirect()->back()->withErrors(['cost_price' => 'Preços inválidos'])->withInput();
        }

        $product->update([
            'name'       => $request->input('name'),
            'category_id'=> $request->input('category_id'),
            'cost_price' => number_format((float)$cost, 2, '.', ''),
            'sale_price' => number_format((float)$sale, 2, '.', ''),
        ]);

        return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso.');
    }


    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produto excluído com sucesso.');
    }
}
