<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\Admin\DatoPersonalController;
use App\Http\Controllers\Admin\ImagenController;
use App\Http\Controllers\Admin\PortafolioController;
/** --- INICIO ACTUALIZACIÓN --- */
use App\Http\Controllers\Admin\ExperienciaController; // ← NUEVO: controlador admin de experiencias
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

    // --- INICIO DE LA ACTUALIZACIÓN ---
    // Resource con parámetro claro para evitar "datos_personale"
    Route::resource('datos-personales', DatoPersonalController::class)
        ->except(['show', 'destroy'])
        ->parameters(['datos-personales' => 'dato_personal']);
    // --- FIN DE LA ACTUALIZACIÓN ---

    // Rutas para Imágenes (CRUD completo)
    Route::resource('imagenes', ImagenController::class);

    // Rutas para Portafolios (CRUD completo)
    Route::resource('portafolios', PortafolioController::class);

    /** --- INICIO ACTUALIZACIÓN --- */
    // Rutas para Experiencias (CRUD completo)
    Route::resource('experiencias', ExperienciaController::class); // ← NUEVO
    /** --- FIN ACTUALIZACIÓN --- */
});
