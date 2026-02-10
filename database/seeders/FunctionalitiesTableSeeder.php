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
                'id' => 2,
                'module_id' => 2,
                'name' => 'Clientes',
                'route' => 'register/clients',
                'order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'module_id' => 2,
                'name' => 'Produtos',
                'route' => 'register/products',
                'order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'module_id' => 2,
                'name' => 'Categorias de Produtos',
                'route' => 'register/categories',
                'order' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'module_id' => 2,
                'name' => 'Fornecedores',
                'route' => 'register/suppliers',
                'order' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'module_id' => 1,
                'name' => 'Permissões',
                'route' => 'system/permissions',
                'order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7,
                'module_id' => 7,
                'name' => 'Eventos',
                'route' => 'calendar',
                'order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'module_id' => 4,
                'name' => 'Consultar',
                'route' => 'stock',
                'order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 9,
                'module_id' => 5,
                'name' => 'Pedidos de Compras',
                'route' => 'purchases',
                'order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 10,
                'module_id' => 6,
                'name' => 'Pedidos de Vendas',
                'route' => 'sales',
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
