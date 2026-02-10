<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ModuleController
{
    public function index()
    {
        $modules = Module::query()
            ->orderBy('order')
            ->orderBy('id')
            ->paginate(20);

        return view('superadmin.modules.index', compact('modules'));
    }

    public function create()
    {
        return view('superadmin.modules.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:modules,slug'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['order'] = $data['order'] ?? 0;
        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        Module::create($data);

        return redirect()->route('superadmin.modules.index')
            ->with('success', 'Módulo criado com sucesso.');
    }

    public function edit(Module $module)
    {
        return view('superadmin.modules.edit', compact('module'));
    }

    public function update(Request $request, Module $module)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('modules', 'slug')->ignore($module->id)],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['order'] = $data['order'] ?? 0;
        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        $module->update($data);

        return redirect()->route('superadmin.modules.index')
            ->with('success', 'Módulo atualizado com sucesso.');
    }

    public function destroy(Module $module)
    {
        $module->delete();

        return redirect()->route('superadmin.modules.index')
            ->with('success', 'Módulo removido com sucesso.');
    }
}
