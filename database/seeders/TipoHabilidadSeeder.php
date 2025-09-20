<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoHabilidad;

class TipoHabilidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoHabilidad::create(['nombre_habilidad' => 'Técnica']);
        TipoHabilidad::create(['nombre_habilidad' => 'Blanda']);
        TipoHabilidad::create(['nombre_habilidad' => 'Gestión']);
    }
}
