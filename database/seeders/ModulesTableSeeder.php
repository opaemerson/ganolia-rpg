<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ModulesTableSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        DB::table('modules')->insert([
            [
                'id' => 1,
                'name' => 'Sistema',
                'slug' => 'system',
                'order' => 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'name' => 'Cadastros',
                'slug' => 'register',
                'order' => 2,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

}
