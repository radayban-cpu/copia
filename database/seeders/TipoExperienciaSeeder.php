<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoExperiencia;

class TipoExperienciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipoExperiencia1 = new TipoExperiencia();
        $tipoExperiencia1->nombre = 'laboral';
        $tipoExperiencia1->save();

        $tipoExperiencia2 = TipoExperiencia::create([
            'nombre' => 'profesional'
        ]);

        $tipoExperiencia3 = TipoExperiencia::create([
            'nombre' => 'educativo'
        ]);

        $tipoExperiencia4 = TipoExperiencia::create([
            'nombre' => 'cultural'
        ]);
    }
}
