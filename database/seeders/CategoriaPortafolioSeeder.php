<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CategoriaPortafolio; // <-- Importante

class CategoriaPortafolioSeeder extends Seeder
{
    public function run(): void
    {
        CategoriaPortafolio::create(['nombre' => 'Diseño Web']);
        CategoriaPortafolio::create(['nombre' => 'Aplicación Móvil']);
        CategoriaPortafolio::create(['nombre' => 'Branding']);
    }
}