<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'manage_users' => 'Gerenciar usuários',
            'manage_clients' => 'Gerenciar clientes',
            'manage_barbers' => 'Gerenciar barbeiros',
            'manage_services' => 'Gerenciar serviços',
            'manage_products' => 'Gerenciar produtos',
            'manage_appointments' => 'Gerenciar agendamentos',
            'manage_sales' => 'Gerenciar vendas',
            'manage_cash' => 'Gerenciar caixa',
        ];

        foreach ($permissions as $name => $description) {
            Permission::create([
                'name' => $name,
                'description' => $description,
            ]);
        }

        // Create roles
        $roles = [
            'admin' => [
                'name' => 'Administrador',
                'description' => 'Acesso total ao sistema',
                'permissions' => array_keys($permissions),
            ],
            'manager' => [
                'name' => 'Gerente',
                'description' => 'Gerenciamento do estabelecimento',
                'permissions' => ['manage_clients', 'manage_barbers', 'manage_services', 'manage_products', 'manage_appointments', 'manage_sales', 'manage_cash'],
            ],
            'barber' => [
                'name' => 'Barbeiro',
                'description' => 'Barbeiro do estabelecimento',
                'permissions' => ['manage_appointments'],
            ],
            'receptionist' => [
                'name' => 'Recepcionista',
                'description' => 'Recepcionista do estabelecimento',
                'permissions' => ['manage_clients', 'manage_appointments', 'manage_sales'],
            ],
        ];

        foreach ($roles as $roleData) {
            $role = Role::create([
                'name' => $roleData['name'],
                'description' => $roleData['description'],
            ]);

            $role->permissions()->attach(
                Permission::whereIn('name', $roleData['permissions'])->pluck('id')
            );
        }

        // Create admin user
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@elbarber.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        $admin->roles()->attach(Role::where('name', 'Administrador')->first());

        $admin = \App\Models\User::with('roles')->where('email', 'admin@elbarber.com')->first();
        $admin->roles->pluck('name');

        $role = \App\Models\Role::with('permissions')->where('name', 'Administrador')->first();
        $role->permissions->pluck('name');
    }
}
