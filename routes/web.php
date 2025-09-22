<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;

// Controladores del Admin
use App\Http\Controllers\Admin\DatoPersonalController;
use App\Http\Controllers\Admin\ImagenController;
use App\Http\Controllers\Admin\PortafolioController;
use App\Http\Controllers\Admin\ExperienciaController;
use App\Http\Controllers\Admin\HabilidadController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\ComentarioController;
use App\Http\Controllers\Admin\ServicioController;
use App\Http\Controllers\Admin\ContactoController;

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

    // Datos Personales
    Route::resource('datos-personales', DatoPersonalController::class)
        ->except(['show', 'destroy'])
        ->parameters(['datos-personales' => 'dato_personal']);

    // Imágenes
    Route::resource('imagenes', ImagenController::class)
        ->parameters(['imagenes' => 'imagen']);

    // Portafolios
    Route::resource('portafolios', PortafolioController::class)
        ->parameters(['portafolios' => 'portafolio']);

    // Experiencias
    Route::resource('experiencias', ExperienciaController::class)
        ->parameters(['experiencias' => 'experiencia']);

    // Habilidades
    Route::resource('habilidades', HabilidadController::class)
        ->parameters(['habilidades' => 'habilidad'])
        ->except(['show']);

    // Testimonios (Clientes y Comentarios)
    Route::resource('clientes', ClienteController::class);
    Route::resource('clientes.comentarios', ComentarioController::class)->shallow();

    // Servicios
    Route::resource('servicios', ServicioController::class);
    
    // --- RUTA DE CONTACTOS RESTAURADA A RESOURCE ---
    Route::resource('contactos', ContactoController::class);
}); 