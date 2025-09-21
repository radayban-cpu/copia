<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoImagen; // <-- Importamos el modelo

class TipoImagenSeeder extends Seeder
{
    /**

     */
    public function run(): void
    {
        TipoImagen::create(['tipo_imagen' => 'Perfil']);
        TipoImagen::create(['tipo_imagen' => 'Muro']);
        TipoImagen::create(['tipo_imagen' => 'Portafolio']);
    }
}