<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Experiencia;

class ExperienciaSeeder extends Seeder
{
    public function run(): void
    {
        Experiencia::create([
            'titulo' => 'Desarrollador Backend',
            'descripcion' => 'Proyecto Laravel 11 en equipo',
            'fecha_inicio' => '2023-01-01',
            'fecha_fin' => '2023-12-31',
            'dato_personal_id' => 1, // debe existir en datos_personales
            'tipo_experiencia_id' => 1, // debe existir en tipos_experiencias
        ]);

        Experiencia::create([
            'titulo' => 'Estudiante Universitario',
            'descripcion' => 'Carrera de Contabilidad en la UNA',
            'fecha_inicio' => '2020-02-01',
            'fecha_fin' => null, // aún en curso
            'dato_personal_id' => 1,
            'tipo_experiencia_id' => 3, // "educativo" en tu seeder
        ]);
    }
}
