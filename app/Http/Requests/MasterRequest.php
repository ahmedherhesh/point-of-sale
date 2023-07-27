<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class MasterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function messages()
    {
        return [
            'required' => 'هذا الحقل مطلوب',
            'exists' => 'غير موجود',
            'mimes' => 'عفوا هذا الملف غير مدعوم ',
            'min:4' => 'مطلوب 4 احرف على الأقل',
            'min:4' => 'مطلوب 4 احرف على الأقل',
        ];
    }
    // public function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(
    //         response()->json($validator->errors(), 422)
    //     );
    // }
}
