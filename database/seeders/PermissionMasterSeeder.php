<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionMasterSeeder extends Seeder
{
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
}
