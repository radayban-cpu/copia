<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        Cliente::create([
            'nombre' => 'Maria Ines Aquino',
            'empresa' => 'MA Solutions',
            'email' => 'maria.aquino@techsolutions.com',
            'telefono' => '+595981111111',
        ]);

        Cliente::create([
            'nombre' => 'Sol Gonzalez',
            'empresa' => 'CM PREMIRES',
            'email' => 'solm@gmail.com',
            'telefono' => '+595982222222',
        ]);

        Cliente::create([
            'nombre' => 'Andres Lopez',
            'empresa' => 'Diseños feos',
            'email' => 'AG@discreativos.com',
            'telefono' => '+595983333333',
        ]);
    }
}
