<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Ejecuta todos los seeders del proyecto en un orden seguro.
     */
    public function run(): void
    {
        // 1) Tablas de catálogos / tipos (no dependen de nada)
        $this->call([
            TipoImagenSeeder::class,
            TipoHabilidadSeeder::class,
            TipoExperienciasSeeder::class,
            TipoContactoSeeder::class,
            CategoriaPortafolioSeeder::class,
        ]);

        // 2) Entidades base que otras usan como FK
        $this->call([
            DatoPersonalSeeder::class,
            PerfilSeeder::class,      // si usa dato_personal_id, debe ir después de DatoPersonal
            ClienteSeeder::class,
        ]);

        // 3) Entidades que dependen de los tipos/base
        $this->call([
            HabilidadSeeder::class,   // requiere tipos_habilidades + dato_personal
            ExperienciaSeeder::class, // requiere tipos_experiencias + dato_personal
            ContactoSeeder::class,    // requiere tipo_contacto (+ cliente si tu modelo lo referencia)
            ComentarioSeeder::class,  // si depende de cliente/portafolio/etc., ya están arriba
        ]);

        // Si más adelante agregás otros (p. ej. PortafolioSeeder),
        // ubicalos aquí respetando dependencias (categoría/cliente primero).
    }
}
