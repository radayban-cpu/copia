<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Perfil;

class PerfilSeeder extends Seeder
{
    public function run(): void
    {
        Perfil::create([
            'titulo' => 'Desarrollador Full Stack',
            'subtitulo' => 'Laravel & Vue.js',
            'descripcion' => 'Apasionado por crear aplicaciones web modernas y escalables.',
            'dato_personal_id' => 1,
        ]);

        Perfil::create([
            'titulo' => 'Diseñador UI/UX',
            'subtitulo' => 'Figma & Adobe XD',
            'descripcion' => 'Experiencia en diseño centrado en el usuario y prototipado rápido.',
            'dato_personal_id' => 1,
        ]);

        Perfil::create([
            'titulo' => 'Administrador de Bases de Datos',
            'subtitulo' => 'MySQL & PostgreSQL',
            'descripcion' => 'Gestión de datos eficiente y optimización de consultas SQL.',
            'dato_personal_id' => 1,
        ]);
    }
}
