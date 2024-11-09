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
            'client_id' => 'required|exists:clients,id',
            'amount' => 'required|numeric|min:0|max:99999999999.99',
            'notes' => 'nullable|min:2|max:254',
            'type' => 'required|in:debit,credit',
        ];
    }
}
