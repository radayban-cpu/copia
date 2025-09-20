<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comentario;

class ComentarioSeeder extends Seeder
{
    public function run(): void
    {
        Comentario::create([
            'contenido' => 'Una de las experiencias que tuve en mi vida.',
            'cliente_id' => 1,
        ]);

        Comentario::create([
            'contenido' => 'Muy satisfecho con el diseño entregado, pero Olimpia desastre lgmt.',
            'cliente_id' => 2,
        ]);

        Comentario::create([
            'contenido' => 'La comunicación fue clara y rápida, pero el empleado me cae mal.',
            'cliente_id' => 3,
        ]);

        Comentario::create([
            'contenido' => 'Volvería a contratar sin dudarlo, eso diria si fuera tonto.',
            'cliente_id' => 1,
        ]);

        Comentario::create([
            'contenido' => 'Trabajo entregado fuera del plazo acordado.',
            'cliente_id' => 2,
        ]);
    }
}
