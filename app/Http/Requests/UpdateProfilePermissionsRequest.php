<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfilePermissionsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'module_ids' => ['array'],
            'module_ids.*' => [
                'integer',
                Rule::exists('modules', 'id')->where('is_active', true),
            ],
            'functionality_ids' => ['array'],
            'functionality_ids.*' => [
                'integer',
                Rule::exists('functionalities', 'id'),
            ],
        ];
    }
}
