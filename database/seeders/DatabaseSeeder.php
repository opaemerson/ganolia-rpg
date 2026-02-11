<?php

namespace Database\Seeders;

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
        ]);
    }
}
