<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        Cliente::create([
            'nombre' => 'María González',
            'empresa' => 'Adrano Ayala Solutions',
            'email' => 'maria.gonzalez@techsolutions.com',
            'telefono' => '+595981111111',
        ]);

        Cliente::create([
            'nombre' => 'Derlis Gonzalez Prime',
            'empresa' => 'Monse mi amor Pro',
            'email' => 'juan.perez@marketingpro.com',
            'telefono' => '+595982222222',
        ]);

        Cliente::create([
            'nombre' => 'Nilce Jaja',
            'empresa' => 'Diseños feos',
            'email' => 'laura.fernandez@discreativos.com',
            'telefono' => '+595983333333',
        ]);
    }
}
