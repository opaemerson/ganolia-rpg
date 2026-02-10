<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController 
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $suppliers = Supplier::when($q, fn($qry) => $qry->where('name', 'like', "%{$q}%"))
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('register.list-supplier', compact('suppliers'));
    }

    public function create()
    {
        return view('register.create-supplier');
    }

    public function store(SupplierRequest $request)
    {
        $data = $request->validated();

        Supplier::create($data);

        return redirect()->route('suppliers.index')->with('success', 'Fornecedor criado com sucesso.');
    }

    public function edit(Supplier $supplier)
    {
        return view('register.edit-supplier', compact('supplier'));
    }

    public function update(SupplierRequest $request, Supplier $supplier)
    {
        $data = $request->validated();

        $supplier->update($data);

        return redirect()->route('suppliers.index')->with('success', 'Fornecedor atualizado com sucesso.');
    }

    public function destroy(Supplier $supplier)
    {
        if ($supplier->products()->exists()) {
            return redirect()->route('suppliers.index')->withErrors('Não é possível excluir: existem produtos vinculados a este fornecedor.');
        }

        $supplier->delete();

        return redirect()->route('suppliers.index')->with('success', 'Fornecedor excluído com sucesso.');
    }
}
