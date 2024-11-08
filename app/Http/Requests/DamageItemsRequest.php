<?php

namespace App\Http\Requests;

use App\Models\Item;
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
            'stock' => [
                'required',
                'gt:0',
                function ($attribute, $value, $fail) {
                    $item = Item::where('code', request('code'))->first();
                    if ($item && ($value > $item->stock) && !$this->damage) {
                        $fail("The {$attribute} must not be greater than available stock ({$item->stock}).");
                    }
                },
            ],
        ];
    }
}
