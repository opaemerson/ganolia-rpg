<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function showDetails($id)
    {
        $user = User::with([
            'clients',
            'providers',
            'addresses',
            'addresses.type'
        ])->find($id);

        if (!$user) {
            abort(404, 'Usuário não encontrado.');
        }

        return $user;
    }
}
