<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\Functionality;
use App\Models\Module;
use Illuminate\Http\Request;

class FunctionalityController
{
    public function index(Request $request)
    {
        $query = Functionality::query()->with('module')->orderBy('module_id')->orderBy('order')->orderBy('id');

        if ($request->filled('module_id')) {
            $query->where('module_id', (int) $request->input('module_id'));
        }

        $functionalities = $query->paginate(30)->withQueryString();
        $modules = Module::query()->orderBy('order')->orderBy('name')->get(['id', 'name']);

        return view('superadmin.functionalities.index', compact('functionalities', 'modules'));
    }

    public function create()
    {
        $modules = Module::query()->orderBy('order')->orderBy('name')->get(['id', 'name']);

        return view('superadmin.functionalities.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'module_id' => ['required', 'integer', 'exists:modules,id'],
            'name' => ['required', 'string', 'max:255'],
            'route' => ['required', 'string', 'max:255'],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['order'] = $data['order'] ?? 0;

        Functionality::create($data);

        return redirect()->route('superadmin.functionalities.index')
            ->with('success', 'Funcionalidade criada com sucesso.');
    }

    public function edit(Functionality $functionality)
    {
        $modules = Module::query()->orderBy('order')->orderBy('name')->get(['id', 'name']);

        return view('superadmin.functionalities.edit', compact('functionality', 'modules'));
    }

    public function update(Request $request, Functionality $functionality)
    {
        $data = $request->validate([
            'module_id' => ['required', 'integer', 'exists:modules,id'],
            'name' => ['required', 'string', 'max:255'],
            'route' => ['required', 'string', 'max:255'],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['order'] = $data['order'] ?? 0;

        $functionality->update($data);

        return redirect()->route('superadmin.functionalities.index')
            ->with('success', 'Funcionalidade atualizada com sucesso.');
    }

    public function destroy(Functionality $functionality)
    {
        $functionality->delete();

        return redirect()->route('superadmin.functionalities.index')
            ->with('success', 'Funcionalidade removida com sucesso.');
    }
}
