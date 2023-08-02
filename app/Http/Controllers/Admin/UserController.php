<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MasterController;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\UpdateUserRequest;
use App\Http\Resources\UsersResource;
use App\Models\Depository;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends MasterController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('role', '!=', 'super-admin')->latest()->paginate(30);
        return inertia('Users/Users', ['users' => UsersResource::collection($users)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Users/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request)
    {
        User::create($request->all());
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if ($user->role != 'super-admin')
            return inertia('Users/Edit', ['user' => $user]);
        return redirect()->back()->with('failed', 'لا تملك الصلاحية للتعديل على هذا المستخدم');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if ($user->role != 'super-admin') {
            $data = $request->all();
            if (!$data['password'])
                $data = $request->except('password');
            $update_user = $user->update($data);
            if ($update_user)
                return redirect()->back()->with('success', 'تم تحديث المستخدم بنجاح');
        }
        return redirect()->back()->with('failed', 'لا تملك الصلاحية للتعديل على هذا المستخدم');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $delete_user = null;
        if ($user->role != 'super-admin')
            $delete_user = $user->delete();
        if ($delete_user)
            return redirect()->back()->with('success', 'تم حذف المستخدم بنجاح');
        return redirect()->back()->with('failed', 'لأ تملك الصلاحية لحذف هذا المستخدم');
    }
}
