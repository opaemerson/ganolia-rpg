<?php

namespace App\Http\Controllers;

use App\Enum\ProfileEnum;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use App\Services\ApiResponseService;
use App\Services\EmailService;

class UserController
{
    public function index(Request $request)
    {
        $search = $request->get('q');
        $adminProfileId = ProfileEnum::SUPERADMIN->id();

        $users = User::with('profile')
            ->when($adminProfileId, fn($qry) => $qry->where('profile_id', '!=', $adminProfileId))
            ->when($search, fn($qry) => $qry->where('email', 'like', "%{$search}%")->orWhere('login', 'like', "%{$search}%"))
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('register.list-user', compact('users'));
    }

    public function create()
    {
        $profiles = Profile::query()
            ->where('name', '!=', ProfileEnum::SUPERADMIN->value)
            ->orderBy('name')
            ->get();
        return view('register.create-user', compact('profiles'));
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $profiles = Profile::query()
            ->where('name', '!=', ProfileEnum::SUPERADMIN->value)
            ->orderBy('name')
            ->get();
        return view('register.edit-user', compact('user', 'profiles'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso.');
    }

    public function forgotPassword(ForgetPasswordRequest $request)
    {
        $data = $request->validated();
        EmailService::sendForgetPasswordEmail($data);

        return ApiResponseService::success('Código de redefinição enviado para seu e-mail');
    }
}
