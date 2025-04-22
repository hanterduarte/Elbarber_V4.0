<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Criar role de administrador
        $adminRole = Role::create([
            'name' => 'admin',
            'description' => 'Administrador do sistema'
        ]);

        // Atribuir todas as permissões ao administrador
        $adminRole->permissions()->attach(Permission::all());

        // Criar role de gerente
        $managerRole = Role::create([
            'name' => 'manager',
            'description' => 'Gerente do estabelecimento'
        ]);

        // Atribuir permissões específicas ao gerente
        $managerPermissions = Permission::whereIn('name', [
            'manage_clients',
            'manage_barbers',
            'manage_services',
            'manage_products',
            'manage_appointments',
            'manage_sales',
            'manage_cash'
        ])->get();

        $managerRole->permissions()->attach($managerPermissions);

        // Criar role de barbeiro
        $barberRole = Role::create([
            'name' => 'barber',
            'description' => 'Barbeiro do estabelecimento'
        ]);

        // Atribuir permissões específicas ao barbeiro
        $barberPermissions = Permission::whereIn('name', [
            'manage_appointments'
        ])->get();

        $barberRole->permissions()->attach($barberPermissions);

        // Criar role de recepcionista
        $receptionistRole = Role::create([
            'name' => 'receptionist',
            'description' => 'Recepcionista do estabelecimento'
        ]);

        // Atribuir permissões específicas ao recepcionista
        $receptionistPermissions = Permission::whereIn('name', [
            'manage_clients',
            'manage_appointments',
            'manage_sales'
        ])->get();

        $receptionistRole->permissions()->attach($receptionistPermissions);
    }
} 