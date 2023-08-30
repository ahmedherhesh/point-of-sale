<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DamageItemsRequest extends MasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'code'  => 'required|exists:items,code',
            'stock' => 'required|gt:0'
        ];
    }
}
