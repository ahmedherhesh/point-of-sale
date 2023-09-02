<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Contracts\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'username' => 'admin',
                'password' => 'secret',
            ],
            [
                'name' => 'User',
                'username' => 'user',
                'password' => 'secret',
            ],
        ];
        foreach ($users as $user) {
            $user = User::create($user);
            if ($user->username != 'admin') {
                $user->assignRole('user');
                $user->givePermissionTo([
                    'المبيعات',
                    'اضافة المبيعات',
                    'اضافة المبيعات',
                    'تعديل المبيعات',
                    'حذف المبيعات',
                    'المنتجات التالفة',
                    'اضافة المنتجات التالفة',
                    'تعديل المنتجات التالفة',
                    'حذف المنتجات التالفة',
                    'الأرباح الإضافية',
                    'اضافة الأرباح الإضافية',
                    'تعديل الأرباح الإضافية',
                    'حذف الأرباح الإضافية',
                ]);
            } else {
                $user->assignRole('admin');
                $permissions = DB::table('permissions')->get(['name']);
                foreach ($permissions as $permission) {
                    $user->givePermissionTo($permission->name);
                }
            }
        }
    }
}
