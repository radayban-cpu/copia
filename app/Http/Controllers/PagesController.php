<?php

namespace App\Http\Controllers;

use App\Models\DatoPersonal;
use App\Models\Imagen;
use App\Models\Portafolio;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function inicio()
    {
        $datoPersonal = DatoPersonal::first();
        $imagenPerfil = Imagen::where('tipo_imagen_id', 1)->first();
        $imagenMuro = Imagen::where('tipo_imagen_id', 2)->first();
        
        return view('inicio', compact('datoPersonal', 'imagenPerfil', 'imagenMuro'));
    }

    public function acerca()
    {
        // Lógica para la página "Acerca de"
        return view('acerca-de');
    }

    public function contactos()
    {
        // Lógica para la página "Contactos"
        return view('contactos');
    }

    public function portafolio()
    {
        $portafolios = Portafolio::with('categoria')->get();
        return view('portafolio', compact('portafolios'));
    }

    public function portafolioDetalle()
    {
        // Lógica para la página "Detalle del Portafolio"
        return view('portafolio-detalle');
    }

    public function resumen()
    {
        // Lógica para la página "Resumen"
        return view('resumen');
    }

    public function servicios()
    {
        // Lógica para la página "Servicios"
        return view('servicios');
    }
}