<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DatoPersonal;
use Illuminate\Http\Request;

class DatoPersonalController extends Controller
{
    /**
     * Muestra la lista de datos personales.
     */
    public function index()
    {
        $datos = DatoPersonal::first();
        return view('admin.datos-personales.index', compact('datos'));
    }

    /**
     * Muestra el formulario para editar los datos personales.
     */
    public function edit(DatoPersonal $dato_personal)
    {
        return view('admin.datos-personales.edit', compact('dato_personal'));
    }

    /**
     * Actualiza los datos personales en la base de datos.
     */
    public function update(Request $request, DatoPersonal $dato_personal)
    {
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'subtitulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'ciudad' => 'required|string|max:255',
            'edad' => 'required|integer',
            'carrera' => 'required|string|max:255',
            'frase' => 'required|string|max:255',
        ]);

        $dato_personal->update($validatedData);

        return redirect()->route('admin.datos-personales.index')->with('success', 'Datos personales actualizados con éxito.');
    }
}