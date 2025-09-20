<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Habilidad;

class HabilidadSeeder extends Seeder
{
    public function run(): void
    {
        Habilidad::create([
            'nombre' => 'Laravel',
            'nivel' => 90,
            'dato_personal_id' => 1, // debe existir en datos_personales
            'tipo_habilidad_id' => 1, // técnica
        ]);

        Habilidad::create([
            'nombre' => 'Trabajo en equipo',
            'nivel' => 85,
            'dato_personal_id' => 1,
            'tipo_habilidad_id' => 2, // blanda
        ]);
    }
}
