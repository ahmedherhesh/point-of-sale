<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class DebitPermissionSeeder extends PermissionMasterSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createPermission('الديون');
        Permission::create(['name' => 'تسديد الديون']);
    }
}
