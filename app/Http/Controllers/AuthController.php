<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends MasterController
{
    public function login()
    {
        if (auth()->user())
            return redirect()->back();
        return inertia('Auth/Login');
    }
    public function _login(LoginRequest $request)
    {
        $user = $request->only('username', 'password');
        $user = auth()->attempt($user,true);
        if ($user) {
            $user = auth()->user();
            if ($user->status == 'active') {
                $request->session()->put('user', $user);
                return redirect('/');
            }
        }
        return redirect()->back()->with('failed', 'إسم المستخدم أو كلمة السر غير صحيحة');
    }
    public function changePassword()
    {
        return inertia('Auth/ChangePassword');
    }
    public function _changePassword(ChangePasswordRequest $request)
    {
        $user = User::find($this->user()->id);
        if (Hash::check($request->oldPassword, $user->password)) {
            $user = $user->update(['password' => $request->password]);
            if ($user)
                return redirect()->back()->with('success', 'تم تغيير كلمة السر بنجاح');
        }
        return redirect()->back()->with('password-error', 'كلمة السر القديمة غير صحيحه');
    }
    public function logout()
    {
        auth()->logout();
        return redirect('login');
    }
}
