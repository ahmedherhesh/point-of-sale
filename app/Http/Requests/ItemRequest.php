<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends MasterRequest
{

    public function rules(): array
    {
        $id = $this->route('item')->id ?? '';
        return [
            'user_id' => 'nullable|exists:users,id',
            'title'   => 'required|min:4|max:254',
            'notes'   => 'nullable|min:4',
            'cat_id'  => 'required|exists:categories,id',
            'sub_cat_id' => 'nullable|exists:categories,id',
            'company_id' => 'nullable|exists:companies,id',
            'price'   => 'required|numeric|max:999999999|min:1|gt:0',
            'sale_price' => 'required|numeric|max:999999999|min:1|gt:0',
            'whole_sale_price' => 'required|numeric|max:999999999|min:1|gt:0',
            'stock'   => 'required|numeric|max:999999999|min:1|gt:0',
            'code'    => 'nullable|min:1|gt:0|unique:items,code,' . $id ,
            'image'   => 'nullable|max:9216|mimes:png,jpg,jpeg,gif,svg',
            'status'  => 'nullable|in:new,used,expired',
        ];
    }
}
