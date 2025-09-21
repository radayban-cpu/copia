<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DatoPersonal;
use App\Models\Imagen;
use App\Models\TipoImagen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagenController extends Controller
{
    public function index()
    {
        // --- INICIO DE LA ACTUALIZACIÓN ---
        // Usamos el nombre correcto de la relación: 'tipo'
        $imagenes = Imagen::with('tipo')->get();
        // --- FIN DE LA ACTUALIZACIÓN ---
        return view('admin.imagenes.index', compact('imagenes'));
    }

    // ... (El resto de los métodos se mantienen igual)
    public function create()
    {
        $tipos = TipoImagen::all();
        return view('admin.imagenes.create', compact('tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ruta' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'descripcion' => 'nullable|string|max:255',
            'tipo_imagen_id' => 'required|exists:tipos_imagenes,id',
        ]);

        $datoPersonal = DatoPersonal::first();
        if (!$datoPersonal) {
            return back()->with('error', 'Debes crear tus datos personales antes de subir una imagen.');
        }

        $path = $request->file('ruta')->store('imagenes', 'public');

        Imagen::create([
            'ruta' => $path,
            'descripcion' => $request->descripcion,
            'tipo_imagen_id' => $request->tipo_imagen_id,
            'dato_personal_id' => $datoPersonal->id,
        ]);

        return redirect()->route('admin.imagenes.index')->with('success', 'Imagen subida con éxito.');
    }

    public function edit(Imagen $imagene)
    {
        $tipos = TipoImagen::all();
        return view('admin.imagenes.edit', ['imagen' => $imagene, 'tipos' => $tipos]);
    }

    public function update(Request $request, Imagen $imagene)
    {
        $request->validate([
            'descripcion' => 'nullable|string|max:255',
            'tipo_imagen_id' => 'required|exists:tipos_imagenes,id',
        ]);

        $imagene->update($request->only(['descripcion', 'tipo_imagen_id']));

        return redirect()->route('admin.imagenes.index')->with('success', 'Imagen actualizada con éxito.');
    }

    public function destroy(Imagen $imagene)
    {
        Storage::disk('public')->delete($imagene->ruta);
        $imagene->delete();

        return redirect()->route('admin.imagenes.index')->with('success', 'Imagen eliminada con éxito.');
    }
}