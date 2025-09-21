<?php

namespace App\Http\Controllers;

use App\Models\DatoPersonal;
use App\Models\Experiencia;
use App\Models\Habilidad;
use App\Models\Imagen;
use App\Models\Portafolio;
use App\Models\Servicio;
use App\Models\CategoriaPortafolio;
use App\Models\TipoImagen; // <-- 1. Importamos el modelo que faltaba

class PagesController extends Controller
{
    public function inicio()
    {
        $datos = DatoPersonal::first(); 
        $imagenPerfil = Imagen::where('tipo_imagen_id', 1)->first();
        $imagenMuro = Imagen::where('tipo_imagen_id', 2)->first();
        
        return view('inicio', compact('datos', 'imagenPerfil', 'imagenMuro'));
    }

    public function acerca()
    {
        $datos = DatoPersonal::first();
        return view('acerca-de', compact('datos'));
    }

    public function contactos()
    {
        return view('contactos');
    }

    public function portafolio()
    {
        // --- INICIO DE LA ACTUALIZACIÓN ---
        // Ahora la función busca todas las IMÁGENES con su TIPO asociado.
        $imagenes = Imagen::with('tipo')->get();
        
        // Y busca la lista completa de TIPOS DE IMAGEN para los filtros.
        $tipos = TipoImagen::all();
        
        // Envía las variables 'imagenes' y 'tipos' a la vista.
        return view('portafolio', compact('imagenes', 'tipos'));
        // --- FIN DE LA ACTUALIZACIÓN ---
    }

    public function portafolioDetalle()
    {
        return view('portafolio-detalle');
    }

    public function resumen()
    {
        $datos = DatoPersonal::first();
        $experiencias = Experiencia::all();
        $habilidades = Habilidad::all();
        return view('resumen', compact('datos', 'experiencias', 'habilidades'));
    }

    public function servicios()
    {
        $servicios = Servicio::all();
        return view('servicios', compact('servicios'));
    }
}