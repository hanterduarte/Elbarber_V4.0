<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            [
                'name' => 'Visualizar Usuários',
                'slug' => 'view-users',
                'description' => 'Permite visualizar a lista de usuários'
            ],
            [
                'name' => 'Criar Usuários',
                'slug' => 'create-users',
                'description' => 'Permite criar novos usuários'
            ],
            [
                'name' => 'Editar Usuários',
                'slug' => 'edit-users',
                'description' => 'Permite editar usuários existentes'
            ],
            [
                'name' => 'Excluir Usuários',
                'slug' => 'delete-users',
                'description' => 'Permite excluir usuários'
            ],
            [
                'name' => 'Gerenciar Permissões',
                'slug' => 'manage-permissions',
                'description' => 'Permite gerenciar permissões do sistema'
            ],
            [
                'name' => 'Gerenciar Papéis',
                'slug' => 'manage-roles',
                'description' => 'Permite gerenciar papéis do sistema'
            ],
            [
                'name' => 'Visualizar Relatórios',
                'slug' => 'view-reports',
                'description' => 'Permite visualizar relatórios do sistema'
            ],
            [
                'name' => 'Gerenciar Agendamentos',
                'slug' => 'manage-appointments',
                'description' => 'Permite gerenciar agendamentos'
            ],
            [
                'name' => 'Gerenciar Serviços',
                'slug' => 'manage-services',
                'description' => 'Permite gerenciar serviços oferecidos'
            ],
            [
                'name' => 'Gerenciar Clientes',
                'slug' => 'manage-clients',
                'description' => 'Permite gerenciar clientes'
            ]
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
} 