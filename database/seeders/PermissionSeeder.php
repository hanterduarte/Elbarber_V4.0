<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Permissões de Usuários
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
            
            // Permissões de Sistema
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
            
            // Permissões de Serviços
            [
                'name' => 'Visualizar Serviços',
                'slug' => 'view-services',
                'description' => 'Permite visualizar serviços'
            ],
            [
                'name' => 'Criar Serviços',
                'slug' => 'create-services',
                'description' => 'Permite criar novos serviços'
            ],
            [
                'name' => 'Editar Serviços',
                'slug' => 'edit-services',
                'description' => 'Permite editar serviços existentes'
            ],
            [
                'name' => 'Excluir Serviços',
                'slug' => 'delete-services',
                'description' => 'Permite excluir serviços'
            ],
            
            // Permissões de Agendamentos
            [
                'name' => 'Visualizar Agendamentos',
                'slug' => 'view-appointments',
                'description' => 'Permite visualizar agendamentos'
            ],
            [
                'name' => 'Criar Agendamentos',
                'slug' => 'create-appointments',
                'description' => 'Permite criar novos agendamentos'
            ],
            [
                'name' => 'Editar Agendamentos',
                'slug' => 'edit-appointments',
                'description' => 'Permite editar agendamentos existentes'
            ],
            [
                'name' => 'Excluir Agendamentos',
                'slug' => 'delete-appointments',
                'description' => 'Permite excluir agendamentos'
            ],
            
            // Permissões de Produtos
            [
                'name' => 'Visualizar Produtos',
                'slug' => 'view-products',
                'description' => 'Permite visualizar produtos'
            ],
            [
                'name' => 'Criar Produtos',
                'slug' => 'create-products',
                'description' => 'Permite criar novos produtos'
            ],
            [
                'name' => 'Editar Produtos',
                'slug' => 'edit-products',
                'description' => 'Permite editar produtos existentes'
            ],
            [
                'name' => 'Excluir Produtos',
                'slug' => 'delete-products',
                'description' => 'Permite excluir produtos'
            ],
            
            // Permissões de Clientes
            [
                'name' => 'Visualizar Clientes',
                'slug' => 'view-clients',
                'description' => 'Permite visualizar clientes'
            ],
            [
                'name' => 'Criar Clientes',
                'slug' => 'create-clients',
                'description' => 'Permite criar novos clientes'
            ],
            [
                'name' => 'Editar Clientes',
                'slug' => 'edit-clients',
                'description' => 'Permite editar clientes existentes'
            ],
            [
                'name' => 'Excluir Clientes',
                'slug' => 'delete-clients',
                'description' => 'Permite excluir clientes'
            ],
            
            // Permissões de PDV
            [
                'name' => 'Abrir Caixa',
                'slug' => 'open-cash-register',
                'description' => 'Permite abrir o caixa'
            ],
            [
                'name' => 'Fechar Caixa',
                'slug' => 'close-cash-register',
                'description' => 'Permite fechar o caixa'
            ],
            [
                'name' => 'Fazer Sangria',
                'slug' => 'make-withdrawal',
                'description' => 'Permite fazer sangria do caixa'
            ],
            [
                'name' => 'Fazer Reforço de Caixa',
                'slug' => 'make-reinforcement',
                'description' => 'Permite fazer reforço de caixa'
            ],
            [
                'name' => 'Fazer Venda',
                'slug' => 'make-sale',
                'description' => 'Permite realizar vendas'
            ],
            [
                'name' => 'Permite Desconto',
                'slug' => 'allow-discount',
                'description' => 'Permite aplicar descontos nas vendas'
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
} 