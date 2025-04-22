<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'manage_users', 'description' => 'Gerenciar usuários'],
            ['name' => 'manage_roles', 'description' => 'Gerenciar funções'],
            ['name' => 'manage_clients', 'description' => 'Gerenciar clientes'],
            ['name' => 'manage_barbers', 'description' => 'Gerenciar barbeiros'],
            ['name' => 'manage_services', 'description' => 'Gerenciar serviços'],
            ['name' => 'manage_products', 'description' => 'Gerenciar produtos'],
            ['name' => 'manage_appointments', 'description' => 'Gerenciar agendamentos'],
            ['name' => 'manage_sales', 'description' => 'Gerenciar vendas'],
            ['name' => 'manage_cash', 'description' => 'Gerenciar caixa'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
} 