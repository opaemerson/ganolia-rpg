<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class FunctionalitiesTableSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        DB::table('functionalities')->insert([
            [
                'id' => 1,
                'module_id' => 2,
                'name' => 'Usuários',
                'route' => 'register/users',
                'order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 11,
                'module_id' => 1,
                'name' => 'Perfils',
                'route' => 'system/profiles',
                'order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
