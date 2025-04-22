<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Criar usuário administrador
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@elbarber.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        // Atribuir role de administrador
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $admin->roles()->attach($adminRole->id);
        }
    }
} 