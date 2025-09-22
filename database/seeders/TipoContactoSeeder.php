<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoContacto;

class TipoContactoSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['correo', 'telefono', 'linkedin', 'google_maps'] as $nombre) {
            TipoContacto::firstOrCreate(['nombre' => $nombre]);
        }
    }
}
