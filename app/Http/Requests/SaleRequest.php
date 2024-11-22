<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends MasterRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id'        => 'nullable',
            'customer_name'  => 'nullable|string',
            'customer_phone' => 'nullable|string',
            'discount'       => 'nullable|numeric|max:999999999',
            'is_whole_sale'  => 'nullable|boolean',
            'items'          => 'required',
        ];
    }
}
