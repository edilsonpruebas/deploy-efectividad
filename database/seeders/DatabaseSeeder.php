<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            OperatorsTableSeeder::class, // usuarios, operadores, supervisores
            ProcessSeeder::class,        // ✅ ahora sí se ejecuta
        ]);
    }
}