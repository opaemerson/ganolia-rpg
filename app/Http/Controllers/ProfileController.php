<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController
{
    public function index(Request $request)
    {
        $search = $request->get('q');

        $profiles = Profile::query()
            ->withCount('users')
            ->when($search, fn($qry) => $qry->where('name', 'like', "%{$search}%"))
            ->whereNotIn('name', ['Superadmin', 'Admin', 'Usuário'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('system.profiles.index', compact('profiles'));
    }

    public function create()
    {
        return view('system.profiles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:profiles,name'],
        ]);

        Profile::create($data);

        return redirect()->route('profiles.index')->with('success', 'Perfil criado com sucesso.');
    }

    public function edit(Profile $profile)
    {
        $profile->loadCount('users');
        return view('system.profiles.edit', compact('profile'));
    }

    public function update(Request $request, Profile $profile)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('profiles', 'name')->ignore($profile->id)],
        ]);

        $profile->update($data);

        return redirect()->route('profiles.index')->with('success', 'Perfil atualizado com sucesso.');
    }

    public function destroy(Profile $profile)
    {
        $profile->delete();

        return redirect()->route('profiles.index')->with('success', 'Perfil excluído com sucesso.');
    }
}
