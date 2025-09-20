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
            'nombre'           => 'Tobias',
            'apellido'         => 'Molinas',
            'descripcion'      => 'Desarrollador Laravel',
            'fecha_nacimiento' => '2000-05-15',
            'ciudad_domicilio' => 'Asunción',
        ]);
    }
}
