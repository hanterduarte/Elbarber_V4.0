<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Permissões para Usuários
        Permission::create(['name' => 'Visualizar Usuários', 'tipo_permissao' => 'view-users']);
        Permission::create(['name' => 'Criar Usuários', 'tipo_permissao' => 'create-users']);
        Permission::create(['name' => 'Editar Usuários', 'tipo_permissao' => 'edit-users']);
        Permission::create(['name' => 'Excluir Usuários', 'tipo_permissao' => 'delete-users']);

        // Permissões para Papéis e Permissões
        Permission::create(['name' => 'Gerenciar Permissões', 'tipo_permissao' => 'manage-permissions']);
        Permission::create(['name' => 'Gerenciar Papéis', 'tipo_permissao' => 'manage-roles']);

        // Permissões para Relatórios
        Permission::create(['name' => 'Visualizar Relatórios', 'tipo_permissao' => 'view-reports']);

        // Permissões para Serviços
        Permission::create(['name' => 'Visualizar Serviço', 'tipo_permissao' => 'view-services']);
        Permission::create(['name' => 'Criar Serviços', 'tipo_permissao' => 'create-services']);
        Permission::create(['name' => 'Editar Serviços', 'tipo_permissao' => 'edit-services']);
        Permission::create(['name' => 'Excluir Serviço', 'tipo_permissao' => 'delete-services']);

        // Permissões para Agendamentos
        Permission::create(['name' => 'Visualizar Agendamentos', 'tipo_permissao' => 'view-appointments']);
        Permission::create(['name' => 'Criar Agendamentos', 'tipo_permissao' => 'create-appointments']);
        Permission::create(['name' => 'Editar Agendamentos', 'tipo_permissao' => 'edit-appointments']);
        Permission::create(['name' => 'Excluir Agendamentos', 'tipo_permissao' => 'delete-appointments']);

        // Permissões para Produtos
        Permission::create(['name' => 'Visualizar Produtos', 'tipo_permissao' => 'view-products']);
        Permission::create(['name' => 'Criar Produtos', 'tipo_permissao' => 'create-products']);
        Permission::create(['name' => 'Editar Produtos', 'tipo_permissao' => 'edit-products']);
        Permission::create(['name' => 'Excluir Produtos', 'tipo_permissao' => 'delete-products']);

        // Permissões para Clientes
        Permission::create(['name' => 'Visualizar Clientes', 'tipo_permissao' => 'view-clients']);
        Permission::create(['name' => 'Criar Clientes', 'tipo_permissao' => 'create-clients']);
        Permission::create(['name' => 'Editar Clientes', 'tipo_permissao' => 'edit-clients']);
        Permission::create(['name' => 'Excluir Clientes', 'tipo_permissao' => 'delete-clients']);

        // Permissões para PDV
        Permission::create(['name' => 'Abrir Caixa', 'tipo_permissao' => 'open-cashier']);
        Permission::create(['name' => 'Fechar Caixa', 'tipo_permissao' => 'close-cashier']);
        Permission::create(['name' => 'Fazer Sangria', 'tipo_permissao' => 'make-withdrawal']);
        Permission::create(['name' => 'Fazer Reforço de Caixa', 'tipo_permissao' => 'make-reinforcement']);
        Permission::create(['name' => 'Fazer Venda', 'tipo_permissao' => 'make-sale']);
        Permission::create(['name' => 'Permite Desconto', 'tipo_permissao' => 'allow-discount']);
    }
} 