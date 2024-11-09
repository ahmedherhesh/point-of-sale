<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientPermissionSeeder extends PermissionMasterSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createPermission('العملاء');
    }
}
