<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $supplierId = $this->route('supplier')?->id;

        return [
            'name'     => 'required|string|max:255',
            'document' => ['nullable','string','max:100', Rule::unique('suppliers','document')->ignore($supplierId)],
            'phone'    => 'nullable|string|max:50',
            'email'    => 'nullable|email|max:255',
        ];
    }
}
