<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\MasterRequest;

class UpdateUserRequest extends MasterRequest
{

    public function rules(): array
    {
        $id = $this->route('user')->id;
        return [
            'name'     => 'required|min:4',
            'username' => 'required|min:4|unique:users,username,' . $id,
            'email'    => 'nullable|min:4|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'role'     => 'required|in:admin,user',
            'status'   => 'required|in:active,block',
        ];
    }
}
