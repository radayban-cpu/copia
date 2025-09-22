<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;

use App\Http\Controllers\Admin\DatoPersonalController;
use App\Http\Controllers\Admin\ImagenController;
use App\Http\Controllers\Admin\PortafolioController;
/** --- INICIO ACTUALIZACIÓN --- */
use App\Http\Controllers\Admin\ExperienciaController;   // controlador admin de experiencias
use App\Http\Controllers\Admin\HabilidadController;     // ← NUEVO: controlador admin de habilidades
/** --- FIN ACTUALIZACIÓN --- */

/*
|--------------------------------------------------------------------------
| Rutas Públicas (las que ven tus visitantes)
|--------------------------------------------------------------------------
*/

Route::controller(PagesController::class)->group(function () {
    Route::get('/', 'inicio')->name('inicio');
    Route::get('/acerca-de', 'acerca')->name('acerca');
    Route::get('/contactos', 'contactos')->name('contactos');
    Route::get('/portafolio', 'portafolio')->name('portafolio');
    Route::get('/portafolio/detalle', 'portafolioDetalle')->name('portafolio.detalle');
    Route::get('/resumen', 'resumen')->name('resumen');
    Route::get('/servicios', 'servicios')->name('servicios');
});

/*
|--------------------------------------------------------------------------
| Rutas del Panel de Administración
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/', function () {
        return redirect()->route('admin.datos-personales.index');
    })->name('dashboard');

    // Resource con parámetro claro para evitar "datos_personale"
    Route::resource('datos-personales', DatoPersonalController::class)
        ->except(['show', 'destroy'])
        ->parameters(['datos-personales' => 'dato_personal']);

    // Imágenes (CRUD) → forzamos {imagen}
    Route::resource('imagenes', ImagenController::class)
        ->parameters(['imagenes' => 'imagen']);

    // Portafolios (CRUD) → {portafolio}
    Route::resource('portafolios', PortafolioController::class)
        ->parameters(['portafolios' => 'portafolio']);

    // Experiencias (CRUD) → {experiencia}
    Route::resource('experiencias', ExperienciaController::class)
        ->parameters(['experiencias' => 'experiencia']);

    // --- NUEVO: Habilidades (CRUD) → {habilidad}
    Route::resource('habilidades', HabilidadController::class)
        ->parameters(['habilidades' => 'habilidad'])
        ->except(['show']);
});
