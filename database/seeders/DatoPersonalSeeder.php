<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DatoPersonal;

class DatoPersonalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DatoPersonal::create([
            'nombre'           => 'Matias',
            'apellido'         => 'Murto',
            'descripcion'      => 'Desarrollador Python Jr',
            'fecha_nacimiento' => '2000-12-18',
            'ciudad_domicilio' => 'Capiata',
        ]);
    }
}
