<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DebitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:254',
            'phone' => 'required|string|min:2|max:254',
            'amount' => 'required|numeric|min:0|max:99999999999.99',
            'notes' => 'nullable|min:2|max:254',
            'status' => 'nullable|in:unpaid,paid',
            'type' => 'required|in:debit,credit',
        ];
    }
}
