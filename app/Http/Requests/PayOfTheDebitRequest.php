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
            'type' => 'required|in:full,partial',
            'amount' => 'nullable|required_if:type,partial|numeric|min:0|max:99999999999.99',
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $debit = Debit::find($this->debit_id);
            if ($this->type == 'partial') {
                if ($this->amount > $debit->left_amount) {
                    $validator->errors()->add('amount', 'المبلغ المدفوع يجب ان يكون اقل من او يساوي المبلغ المتبقي');
                }
            }
            // merge debit 
            $this->merge([
                'debit' => $debit
            ]);
        });
    }
}
