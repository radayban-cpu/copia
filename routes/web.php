<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\Admin\DatoPersonalController;
use App\Http\Controllers\Admin\ImagenController;
use App\Http\Controllers\Admin\PortafolioController;

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
    // Hemos cambiado las rutas manuales por un Route::resource.
    // Esto crea automáticamente las rutas para:
    // index, create, store, edit, update.
    // Con except() evitamos crear rutas que no usaremos (como show o destroy para datos personales).
    Route::resource('datos-personales', DatoPersonalController::class)->except(['show', 'destroy']);
    // --- FIN DE LA ACTUALIZACIÓN ---

    // Rutas para Imágenes (CRUD completo)
    Route::resource('imagenes', ImagenController::class);

    // Rutas para Portafolios (CRUD completo)
    Route::resource('portafolios', PortafolioController::class);

});