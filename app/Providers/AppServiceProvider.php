<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\DatoPersonal;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Comparte $datoPersonal y $imagenPerfil con TODAS las vistas
        View::composer('*', function ($view) {
            $datoPersonal = DatoPersonal::first();

            // Detecta automáticamente el primer campo de imagen que exista y no esté vacío:
            $candidatos = ['imagen_perfil', 'foto', 'avatar', 'url_imagen', 'imagen', 'image'];
            $rutaRelativa = null;

            if ($datoPersonal) {
                foreach ($candidatos as $campo) {
                    if (!empty($datoPersonal->{$campo})) {
                        $rutaRelativa = $datoPersonal->{$campo};
                        break;
                    }
                }
            }

            // Asegurate de haber corrido: php artisan storage:link
            $imagenPerfil = $rutaRelativa
                ? asset('storage/' . ltrim($rutaRelativa, '/'))
                : asset('images/avatar.png'); // poné una imagen por defecto en public/images/avatar.png

            $view->with('datoPersonal', $datoPersonal);
            $view->with('imagenPerfil', $imagenPerfil);
        });
    }
}
    