<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Modules\Prueba\Models\User;

class OperatorsTableSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Juan Perez',    'email' => 'juan@prueba.com',   'role' => 'OPERADOR'],
            ['name' => 'Pedro Garcia',  'email' => 'pedro@prueba.com',  'role' => 'OPERADOR'],
            ['name' => 'Maria Lopez',   'email' => 'maria@prueba.com',  'role' => 'OPERADOR'],
            ['name' => 'Carlos Mendez', 'email' => 'carlos@prueba.com', 'role' => 'SUPERVISOR'],
            ['name' => 'Admin',         'email' => 'admin@prueba.com',  'role' => 'ADMIN'],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name'     => $userData['name'],
                    'password' => Hash::make('password'),
                    'role'     => $userData['role'],
                ]
            );
        }
    }
}
