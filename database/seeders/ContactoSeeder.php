<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contacto;

class ContactoSeeder extends Seeder
{
    public function run(): void
    {
        Contacto::create([
            'valor' => 'tobias.molinas@example.com',
            'dato_personal_id' => 1, // id que ya existe en datos_personales
            'tipo_contacto_id' => 1, // Email
        ]);

        Contacto::create([
            'valor' => '+595981234567',
            'dato_personal_id' => 1,
            'tipo_contacto_id' => 2, // WhatsApp
        ]);

        Contacto::create([
            'valor' => 'linkedin.com/in/tobias-molinas',
            'dato_personal_id' => 1,
            'tipo_contacto_id' => 3, // LinkedIn
        ]);
    }
}
