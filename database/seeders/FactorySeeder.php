<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Company;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FactorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(10)->create();
        Category::factory()->count(50)->create();
        Company::factory()->count(50)->create();
        Item::factory()->count(50)->create();
    }
}
