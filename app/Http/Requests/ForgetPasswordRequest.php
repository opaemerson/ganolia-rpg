<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ForgetPasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6',
            'name' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'O email informado não é válido.',
            'email.exists' => 'O email informado nao existe.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
            'name.required' => 'O campo nome é obrigatório.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'error'    => true,
                'message' => $validator->errors()->first(),
                'response' => $validator->errors()->all(),
            ], 422)
        );
    }
}
