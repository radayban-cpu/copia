<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contacto;

class ContactoSeeder extends Seeder
{
    public function run(): void
    {
        Contacto::create([
            'valor' => 'matias_murto@example.com',
            'dato_personal_id' => 1, // id que ya existe en datos_personales
            'tipo_contacto_id' => 1, // Email
        ]);

        Contacto::create([
            'valor' => '+595982993406',
            'dato_personal_id' => 1,
            'tipo_contacto_id' => 2, // WhatsApp
        ]);

        Contacto::create([
            'valor' => 'https://www.linkedin.com/in/matias-murto-683353170/',
            'dato_personal_id' => 1,
            'tipo_contacto_id' => 3, // LinkedIn
        ]);
    }
}
