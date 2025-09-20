<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoContacto;

class TipoContactoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $tipoContacto1 = new TipoContacto();
        $tipoContacto1->nombre = 'Email';
        $tipoContacto1->save();

        $tipoContacto2 = TipoContacto::create([
            'nombre' => 'Whatsapp'
        ]);

        $tipoContacto3 = TipoContacto::create([
            'nombre' => 'Linkedin'
        ]);

        $tipoContacto4 = TipoContacto::create([
            'nombre' => 'Instagram'
        ]);

    }

    // cargar 4 rgsts

    // creando modelo

}
