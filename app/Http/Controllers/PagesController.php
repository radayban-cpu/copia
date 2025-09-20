<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function inicio()
    {
        return view('inicio');
    }

    public function acerca()
    {
        return view('acerca-de');
    }

    public function contactos()
    {
        return view('contactos');
    }

    public function portafolio()
    {
        return view('portafolio');
    }

    public function portafolioDetalle()
    {
        return view('portafolio-detalle');
    }

    public function resumen()
    {
        return view('resumen');
    }

    public function servicios()
    {
        return view('servicios');
    }
}
