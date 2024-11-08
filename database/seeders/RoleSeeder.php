<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends PermissionMasterSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'admin'],
            ['name' => 'user']
        ];
        foreach ($roles as $role) {
            Role::create($role);
        }
        $permissions = [
            'المستخدمين',
            'الأقسام',
            'الشركات',
            'المنتجات',
            'المبيعات',
            'المصروفات',
            'المنتجات التالفة',
            'الأرباح الإضافية',
        ];
        foreach ($permissions as $permission) {
            $this->createPermission($permission);
        }
        Permission::create(['name' => 'الباركود']);
        Permission::create(['name' => 'إجمالي الأرباح']);
        Permission::create(['name' => 'إعدادات التطبيق']);
    }
}
