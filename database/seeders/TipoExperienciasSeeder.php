<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoExperiencia;

class TipoExperienciasSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Educación', 'Profesional', 'Laboral', 'Cultural'] as $nombre) {
            TipoExperiencia::firstOrCreate(['nombre' => $nombre]);
        }
    }
}
