<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends MasterRequest
{

    public function rules(): array
    {
        return [
            'name' => 'required|min:4',
        ];
    }
}
