<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Category;

class CategoryController
{
    public function index(Request $request)
    {
        $search = $request->get('q');
        $categorys = Category::when($search, fn($qry) => $qry->where('name', 'like', "%{$search}%"))
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('register.list-category', compact('categorys'));
    }

    public function create()
    {
        return view('register.create-category');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:255|unique:categories,name']);

        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Produto criado com sucesso.');
    }

    public function edit(Category $category)
    {
        return view('register.edit-category', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255', Rule::unique('categories', 'name')->ignore($category->id),
            ],
        ]);

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Produto atualizado com sucesso.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Produto excluído com sucesso.');
    }
}
