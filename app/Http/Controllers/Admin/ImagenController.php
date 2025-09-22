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
        $imagenes = Imagen::with('tipo')->get();
        return view('admin.imagenes.index', compact('imagenes'));
    }

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

    // --- INICIO DE LA ACTUALIZACIÓN (BUENA PRÁCTICA) ---
    // Cambiamos $imagene por $imagen para seguir la convención de Laravel
    public function edit(Imagen $imagen)
    {
        $tipos = TipoImagen::all();
        // Pasamos la variable a la vista como 'imagen'
        return view('admin.imagenes.edit', compact('imagen', 'tipos'));
    }

    // Cambiamos $imagene por $imagen
    public function update(Request $request, Imagen $imagen)
    {
        $request->validate([
            'ruta' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'descripcion' => 'nullable|string|max:255',
            'tipo_imagen_id' => 'required|exists:tipos_imagenes,id',
        ]);

        $data = $request->only(['descripcion', 'tipo_imagen_id']);

        if ($request->hasFile('ruta')) {
            if ($imagen->ruta) {
                Storage::disk('public')->delete($imagen->ruta);
            }
            $path = $request->file('ruta')->store('imagenes', 'public');
            $data['ruta'] = $path;
        }

        $imagen->update($data);

        return redirect()->route('admin.imagenes.index')->with('success', 'Imagen actualizada con éxito.');
    }

    // Cambiamos $imagene por $imagen
    public function destroy(Imagen $imagen)
    {
        if ($imagen->ruta) {
            Storage::disk('public')->delete($imagen->ruta);
        }
        $imagen->delete();

        return redirect()->route('admin.imagenes.index')->with('success', 'Imagen eliminada con éxito.');
    }
    // --- FIN DE LA ACTUALIZACIÓN ---
}