<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DatoPersonal;
use Illuminate\Http\Request;

class DatoPersonalController extends Controller
{
    public function index()
    {
        $datos = DatoPersonal::first();
        if (!$datos) {
            return redirect()->route('admin.datos-personales.create');
        }
        return view('admin.datos-personales.index', compact('datos'));
    }

    public function create()
    {
        return view('admin.datos-personales.create');
    }

    public function store(Request $request)
    {
        // --- INICIO DE LA ACTUALIZACIÓN ---
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'descripcion' => 'required|string|max:125',
            'fecha_nacimiento' => 'required|date',
            'ciudad_domicilio' => 'required|string|max:255',
            'carrera' => 'nullable|string|max:255', // Campo nuevo
            'frase' => 'nullable|string|max:255',   // Campo nuevo
            'edad' => 'nullable|integer',           // Campo nuevo
        ]);
        // --- FIN DE LA ACTUALIZACIÓN ---

        DatoPersonal::create($validatedData);

        return redirect()->route('admin.datos-personales.index')->with('success', 'Datos personales creados con éxito.');
    }

    public function edit(DatoPersonal $dato_personal)
    {
        return view('admin.datos-personales.edit', compact('dato_personal'));
    }

    public function update(Request $request, DatoPersonal $dato_personal)
    {
        // --- INICIO DE LA ACTUALIZACIÓN ---
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'descripcion' => 'required|string|max:125',
            'fecha_nacimiento' => 'required|date',
            'ciudad_domicilio' => 'required|string|max:255',
            'carrera' => 'nullable|string|max:255', // Campo nuevo
            'frase' => 'nullable|string|max:255',   // Campo nuevo
            'edad' => 'nullable|integer',           // Campo nuevo
        ]);
        // --- FIN DE LA ACTUALIZACIÓN ---

        $dato_personal->update($validatedData);

        return redirect()->route('admin.datos-personales.index')->with('success', 'Datos personales actualizados con éxito.');
    }
}