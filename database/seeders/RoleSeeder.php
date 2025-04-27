<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Criar papel de Administrador
        $admin = Role::create([
            'name' => 'Administrador',
            'description' => 'Administrador do sistema com acesso total'
        ]);

        // Criar papel de Gerente
        $manager = Role::create([
            'name' => 'Gerente',
            'description' => 'Gerente com acesso a relatórios e gerenciamento'
        ]);

        // Criar papel de Barbeiro
        $barber = Role::create([
            'name' => 'Barbeiro',
            'description' => 'Barbeiro com acesso a agendamentos e serviços'
        ]);

        // Criar papel de Recepcionista
        $receptionist = Role::create([
            'name' => 'Recepcionista',
            'description' => 'Recepcionista com acesso a agendamentos e clientes'
        ]);

        // Atribuir todas as permissões ao Administrador
        $admin->permissions()->attach(Permission::all());

        // Atribuir permissões ao Gerente
        $managerPermissions = Permission::whereIn('tipo_permissao', [
            'view-users',
            'view-reports',
            'manage-appointments',
            'manage-services',
            'manage-clients'
        ])->get();
        $manager->permissions()->attach($managerPermissions);

        // Atribuir permissões ao Barbeiro
        $barberPermissions = Permission::whereIn('tipo_permissao', [
            'manage-appointments',
            'manage-services',
            'view-reports'
        ])->get();
        $barber->permissions()->attach($barberPermissions);

        // Atribuir permissões ao Recepcionista
        $receptionistPermissions = Permission::whereIn('tipo_permissao', [
            'manage-appointments',
            'manage-clients'
        ])->get();
        $receptionist->permissions()->attach($receptionistPermissions);
    }
} 