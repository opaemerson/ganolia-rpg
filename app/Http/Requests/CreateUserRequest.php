<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'login'    => 'required|string|max:30|unique:users,login',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ];
    }

    public function messages()
    {
        return [
            'login.required'     => 'O campo login é obrigatório.',
            'login.string'       => 'O login deve ser um texto.',
            'login.max'          => 'O login não pode ter mais que 30 caracteres.',
            'login.unique'       => 'Este login já está em uso.',
            
            'email.required'    => 'O campo e-mail é obrigatório.',
            'email.email'       => 'O e-mail deve ser um endereço válido.',
            'email.unique'      => 'Este e-mail já está em uso.',

            'password.required' => 'A senha é obrigatória.',
            'password.string'   => 'A senha deve ser um texto.',
            'password.min'      => 'A senha deve ter pelo menos 6 caracteres.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
            throw new HttpResponseException(
                response()->json([
                    'error'    => true,
                    'message'  => $validator->errors()->first(),
                    'response' => $validator->errors()->all(),
                ], 422)
            );
        }

        throw new HttpResponseException(
            redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
        );
    }


}

