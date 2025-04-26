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
                'tipo_permissao' => 'view-users',
                'description' => 'Permite visualizar a lista de usuários'
            ],
            [
                'name' => 'Criar Usuários',
                'tipo_permissao' => 'create-users',
                'description' => 'Permite criar novos usuários'
            ],
            [
                'name' => 'Editar Usuários',
                'tipo_permissao' => 'edit-users',
                'description' => 'Permite editar usuários existentes'
            ],
            [
                'name' => 'Excluir Usuários',
                'tipo_permissao' => 'delete-users',
                'description' => 'Permite excluir usuários'
            ],
            
            // Permissões de Sistema
            [
                'name' => 'Visualizar Permissões',
                'tipo_permissao' => 'view-permissions',
                'description' => 'Permite visualizar permissões do sistema'
            ],
            [
                'name' => 'Criar Permissões',
                'tipo_permissao' => 'create-permissions',
                'description' => 'Permite criar novas permissões'
            ],
            [
                'name' => 'Editar Permissões',
                'tipo_permissao' => 'edit-permissions',
                'description' => 'Permite editar permissões existentes'
            ],
            [
                'name' => 'Excluir Permissões',
                'tipo_permissao' => 'delete-permissions',
                'description' => 'Permite excluir permissões'
            ],
            [
                'name' => 'Gerenciar Papéis',
                'tipo_permissao' => 'manage-roles',
                'description' => 'Permite gerenciar papéis do sistema'
            ],
            [
                'name' => 'Visualizar Relatórios',
                'tipo_permissao' => 'view-reports',
                'description' => 'Permite visualizar relatórios do sistema'
            ],
            
            // Permissões de Serviços
            [
                'name' => 'Visualizar Serviços',
                'tipo_permissao' => 'view-services',
                'description' => 'Permite visualizar serviços'
            ],
            [
                'name' => 'Criar Serviços',
                'tipo_permissao' => 'create-services',
                'description' => 'Permite criar novos serviços'
            ],
            [
                'name' => 'Editar Serviços',
                'tipo_permissao' => 'edit-services',
                'description' => 'Permite editar serviços existentes'
            ],
            [
                'name' => 'Excluir Serviços',
                'tipo_permissao' => 'delete-services',
                'description' => 'Permite excluir serviços'
            ],
            
            // Permissões de Agendamentos
            [
                'name' => 'Visualizar Agendamentos',
                'tipo_permissao' => 'view-appointments',
                'description' => 'Permite visualizar agendamentos'
            ],
            [
                'name' => 'Criar Agendamentos',
                'tipo_permissao' => 'create-appointments',
                'description' => 'Permite criar novos agendamentos'
            ],
            [
                'name' => 'Editar Agendamentos',
                'tipo_permissao' => 'edit-appointments',
                'description' => 'Permite editar agendamentos existentes'
            ],
            [
                'name' => 'Excluir Agendamentos',
                'tipo_permissao' => 'delete-appointments',
                'description' => 'Permite excluir agendamentos'
            ],
            
            // Permissões de Produtos
            [
                'name' => 'Visualizar Produtos',
                'tipo_permissao' => 'view-products',
                'description' => 'Permite visualizar produtos'
            ],
            [
                'name' => 'Criar Produtos',
                'tipo_permissao' => 'create-products',
                'description' => 'Permite criar novos produtos'
            ],
            [
                'name' => 'Editar Produtos',
                'tipo_permissao' => 'edit-products',
                'description' => 'Permite editar produtos existentes'
            ],
            [
                'name' => 'Excluir Produtos',
                'tipo_permissao' => 'delete-products',
                'description' => 'Permite excluir produtos'
            ],
            
            // Permissões de Clientes
            [
                'name' => 'Visualizar Clientes',
                'tipo_permissao' => 'view-clients',
                'description' => 'Permite visualizar clientes'
            ],
            [
                'name' => 'Criar Clientes',
                'tipo_permissao' => 'create-clients',
                'description' => 'Permite criar novos clientes'
            ],
            [
                'name' => 'Editar Clientes',
                'tipo_permissao' => 'edit-clients',
                'description' => 'Permite editar clientes existentes'
            ],
            [
                'name' => 'Excluir Clientes',
                'tipo_permissao' => 'delete-clients',
                'description' => 'Permite excluir clientes'
            ],
            
            // Permissões de PDV
            [
                'name' => 'Abrir Caixa',
                'tipo_permissao' => 'open-cash-register',
                'description' => 'Permite abrir o caixa'
            ],
            [
                'name' => 'Fechar Caixa',
                'tipo_permissao' => 'close-cash-register',
                'description' => 'Permite fechar o caixa'
            ],
            [
                'name' => 'Fazer Sangria',
                'tipo_permissao' => 'make-withdrawal',
                'description' => 'Permite fazer sangria do caixa'
            ],
            [
                'name' => 'Fazer Reforço de Caixa',
                'tipo_permissao' => 'make-reinforcement',
                'description' => 'Permite fazer reforço de caixa'
            ],
            [
                'name' => 'Fazer Venda',
                'tipo_permissao' => 'make-sale',
                'description' => 'Permite realizar vendas'
            ],
            [
                'name' => 'Permite Desconto',
                'tipo_permissao' => 'allow-discount',
                'description' => 'Permite aplicar descontos nas vendas'
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
} 