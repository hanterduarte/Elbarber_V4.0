<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Product;
use App\Models\Service;
use App\Models\User;
use App\Models\Barber;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        // Criar clientes
        $clients = [
            [
                'name' => 'João Silva',
                'email' => 'joao@example.com',
                'phone' => '(11) 98765-4321',
                'birth_date' => '1990-01-15',
            ],
            [
                'name' => 'Pedro Santos',
                'email' => 'pedro@example.com',
                'phone' => '(11) 98765-4322',
                'birth_date' => '1985-05-20',
            ],
            [
                'name' => 'Carlos Oliveira',
                'email' => 'carlos@example.com',
                'phone' => '(11) 98765-4323',
                'birth_date' => '1995-08-10',
            ],
        ];

        foreach ($clients as $clientData) {
            Client::create($clientData);
        }

        // Criar produtos
        $products = [
            [
                'name' => 'Pomada Modeladora',
                'description' => 'Pomada para modelar cabelo com fixação forte',
                'price' => 45.90,
                'cost_price' => 25.00,
                'stock' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Shampoo Anticaspa',
                'description' => 'Shampoo especial para tratamento de caspa',
                'price' => 39.90,
                'cost_price' => 20.00,
                'stock' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Óleo para Barba',
                'description' => 'Óleo hidratante para barba',
                'price' => 35.90,
                'cost_price' => 18.00,
                'stock' => 40,
                'is_active' => true,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        // Criar serviços
        $services = [
            [
                'name' => 'Corte de Cabelo',
                'description' => 'Corte masculino tradicional',
                'price' => 45.00,
                'duration' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Barba',
                'description' => 'Fazer a barba com navalha',
                'price' => 35.00,
                'duration' => 20,
                'is_active' => true,
            ],
            [
                'name' => 'Corte + Barba',
                'description' => 'Corte masculino + fazer a barba',
                'price' => 70.00,
                'duration' => 50,
                'is_active' => true,
            ],
        ];

        foreach ($services as $serviceData) {
            Service::create($serviceData);
        }

        // Criar barbeiros
        $barbers = [
            [
                'name' => 'José Barbeiro',
                'email' => 'jose@elbarber.com',
                'password' => 'password',
                'phone' => '(11) 98765-4324',
                'commission_rate' => 50,
                'bio' => 'Especialista em cortes modernos',
            ],
            [
                'name' => 'Antonio Barbeiro',
                'email' => 'antonio@elbarber.com',
                'password' => 'password',
                'phone' => '(11) 98765-4325',
                'commission_rate' => 50,
                'bio' => 'Especialista em barbas',
            ],
        ];

        foreach ($barbers as $barberData) {
            // Criar usuário
            $user = User::create([
                'name' => $barberData['name'],
                'email' => $barberData['email'],
                'password' => Hash::make($barberData['password']),
                'is_active' => true,
            ]);

            // Criar barbeiro
            Barber::create([
                'user_id' => $user->id,
                'phone' => $barberData['phone'],
                'commission_rate' => $barberData['commission_rate'],
                'bio' => $barberData['bio'],
                'is_active' => true,
            ]);
        }

        // Criar alguns agendamentos
        $barber1 = Barber::first();
        $barber2 = Barber::skip(1)->first();
        $service1 = Service::where('name', 'Corte de Cabelo')->first();
        $service2 = Service::where('name', 'Barba')->first();
        $service3 = Service::where('name', 'Corte + Barba')->first();
        $client1 = Client::first();
        $client2 = Client::skip(1)->first();
        $client3 = Client::skip(2)->first();

        $appointments = [
            [
                'client_id' => $client1->id,
                'barber_id' => $barber1->id,
                'service_id' => $service1->id,
                'start_time' => Carbon::today()->setHour(10)->setMinute(0),
                'end_time' => Carbon::today()->setHour(10)->setMinute(30),
                'price' => $service1->price,
                'status' => 'completed',
            ],
            [
                'client_id' => $client2->id,
                'barber_id' => $barber2->id,
                'service_id' => $service2->id,
                'start_time' => Carbon::today()->setHour(11)->setMinute(0),
                'end_time' => Carbon::today()->setHour(11)->setMinute(20),
                'price' => $service2->price,
                'status' => 'completed',
            ],
            [
                'client_id' => $client3->id,
                'barber_id' => $barber1->id,
                'service_id' => $service3->id,
                'start_time' => Carbon::tomorrow()->setHour(14)->setMinute(0),
                'end_time' => Carbon::tomorrow()->setHour(14)->setMinute(50),
                'price' => $service3->price,
                'status' => 'scheduled',
            ],
        ];

        foreach ($appointments as $appointmentData) {
            Appointment::create($appointmentData);
        }
    }
} 