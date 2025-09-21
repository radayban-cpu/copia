<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // --- INICIO DE LA ACTUALIZACIÓN ---
        // El orden es importante: primero tipos/tablas de referencia.
        $this->call([
            TipoExperienciasSeeder::class,   // ← NUEVO: tipos_experiencias
            TipoImagenSeeder::class,
            CategoriaPortafolioSeeder::class,
            // ServicioSeeder::class, // Déjalo comentado si aún no hay DatoPersonal
        ]);
        // --- FIN DE LA ACTUALIZACIÓN ---
    }
}
