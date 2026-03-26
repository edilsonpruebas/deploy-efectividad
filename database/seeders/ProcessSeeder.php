<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Prueba\Models\Process;

class ProcessSeeder extends Seeder
{
    public function run(): void
    {
        $processes = [
            ['name' => 'Doblado',  'is_active' => true, 'base_per_hour' => 0],
            ['name' => 'Corte',    'is_active' => true, 'base_per_hour' => 0],
            ['name' => 'Envibado', 'is_active' => true, 'base_per_hour' => 0],
        ];

        foreach ($processes as $process) {
            // ✅ No duplica en cada deploy
            Process::firstOrCreate(
                ['name' => $process['name']],
                [
                    'is_active'     => $process['is_active'],
                    'base_per_hour' => $process['base_per_hour'],
                ]
            );
        }
    }
}