<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ProfileSeeder::class,
            ModulesTableSeeder::class,
            FunctionalitiesTableSeeder::class,
            SuperadminUserSeeder::class,
            AdminUserSeeder::class,
            CategorySeeder::class,
            SupplierSeeder::class,
        ]);
    }
}
