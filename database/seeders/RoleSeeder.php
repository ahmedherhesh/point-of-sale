<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
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
        function createPermission($permission)
        {
            $permissions = [
                ['name' => "$permission"],
                ['name' => "اضافة $permission"],
                ['name' => "تعديل $permission"],
                ['name' => "حذف $permission"],
            ];
            foreach ($permissions as $permission) {
                Permission::create($permission);
            }
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
            createPermission($permission);
        }
        Permission::create(['name' => 'الباركود']);
        Permission::create(['name' => 'إجمالي الأرباح']);
        Permission::create(['name' => 'إعدادات التطبيق']);
    }
}
