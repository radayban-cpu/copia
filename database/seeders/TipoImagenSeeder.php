<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoImagen;

class TipoImagenSeeder extends Seeder
{
    public function run(): void
    {
        TipoImagen::create(['tipo_imagen' => 'Perfil']);
        TipoImagen::create(['tipo_imagen' => 'Portada']);
        TipoImagen::create(['tipo_imagen' => 'Proyecto']);
    }
}
