<?php

namespace App\Http\Requests;


class ExtraProfitRequest extends MasterRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'amount' => 'required|numeric|max:999999999',
        ];
    }
}
