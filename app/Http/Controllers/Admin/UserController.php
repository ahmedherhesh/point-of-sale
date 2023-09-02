<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\MasterController;
use App\Http\Requests\Auth\UserRequest;
use App\Http\Resources\UsersResource;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends MasterController
{
    public $permission = 'المستخدمين';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->paginate(30);
        return inertia('Users/Users', ['users' => UsersResource::collection($users)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = DB::table('permissions')->get()->pluck('name');
        return inertia('Users/Create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $user = User::create($request->except(['role', 'permissions']));
        $user->assignRole($request->role);
        $user->givePermissionTo($request->permissions);
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
    public function edit($id)
    {
        $user = User::with(['roles'])->findOrFail($id);
        $permissions = DB::table('permissions')->get()->pluck('name');
        return inertia('Users/Edit', ['user' => $user, 'permissions' => $permissions, 'userPermissions' => $user->getAllPermissions()->pluck('name')]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $data = $request->except('permissions', 'role');
        if (!$data['password'])
            $data = $request->except('password');
        $update_user = $user->update($data);
        $user->syncRoles($request->role);
        $user->syncPermissions($request->permissions);
        if ($update_user)
            return redirect()->back()->with('success', 'تم تحديث المستخدم بنجاح');
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
