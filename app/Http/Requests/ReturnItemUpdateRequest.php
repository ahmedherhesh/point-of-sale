<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReturnItemUpdateRequest extends MasterRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'customer_name' => 'nullable',
            'notes' => 'nullable:min:4',
            'qty' => 'required|min:1|gt:0',
            'status' => 'required|in:new,used,expired',
            'in_stock' => 'nullable|in:0,1',
        ];
    }
}
