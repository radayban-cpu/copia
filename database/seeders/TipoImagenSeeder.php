<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class TipoImagenSeeder extends Seeder
{
    public function run(): void
    {
        // Detectar la columna que guarda el nombre del tipo
        $col = 'tipo_imagen';
        if (!Schema::hasColumn('tipos_imagenes', $col)) {
            foreach (['nombre', 'tipo', 'name', 'titulo', 'slug'] as $c) {
                if (Schema::hasColumn('tipos_imagenes', $c)) { $col = $c; break; }
            }
        }

        foreach (['perfil', 'muro'] as $nombre) {
            $exists = DB::table('tipos_imagenes')
                ->whereRaw("LOWER(TRIM($col)) = ?", [Str::lower(trim($nombre))])
                ->exists();

            if (!$exists) {
                DB::table('tipos_imagenes')->insert([$col => $nombre]);
            }
        }
    }
}
