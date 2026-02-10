<?php

namespace App\DTO;

use Illuminate\Support\Facades\Hash;

class CreateUserDTO
{
    public string $login;
    public string $email;
    public string $password;

    public function __construct(array $data)
    {
        $this->login    = strtolower($data['login']);
        $this->email    = strtolower($data['email']);
        $this->password = Hash::make($data['password']);
    }

    public function toArray(): array
    {
        return [
            'login'    => $this->login,
            'email'    => $this->email,
            'password' => $this->password,
        ];
    }
}
