<?php

namespace App\Http\Requests;

use App\Models\Debit;
use Illuminate\Foundation\Http\FormRequest;

class PayOfTheDebitRequest extends FormRequest
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
            'debit_id' => 'required|exists:debits,id',
            'amount' => ['required', 'numeric', function ($attribute, $value, $fail) {
                $debit = Debit::where('id', request('debit_id'))->first();
                if ($value > $debit->amount) {
                    $fail("The {$attribute} must not be greater than available amount ({$debit->amount}).");
                }
            }],
        ];
    }
}
