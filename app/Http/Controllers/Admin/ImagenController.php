<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Imagen;
use App\Models\TipoImagen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagenController extends Controller
{
    /**
     * Muestra una lista de imágenes.
     */
    public function index()
    {
        $imagenes = Imagen::all();
        return view('admin.imagenes.index', compact('imagenes'));
    }

    /**
     * Muestra el formulario para crear una nueva imagen.
     */
    public function create()
    {
        $tipos = TipoImagen::all();
        return view('admin.imagenes.create', compact('tipos'));
    }

    /**
     * Almacena una nueva imagen en la base de datos y en el disco.
     */
    public function store(Request $request)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'descripcion' => 'required|string|max:255',
            'tipo_imagen_id' => 'required|exists:tipos_imagenes,id',
        ]);

        $path = $request->file('imagen')->store('uploads', 'public');

        Imagen::create([
            'ruta' => $path,
            'descripcion' => $request->descripcion,
            'tipo_imagen_id' => $request->tipo_imagen_id,
        ]);

        return redirect()->route('admin.imagenes.index')->with('success', 'Imagen subida con éxito.');
    }

    /**
     * Elimina una imagen del almacenamiento y de la base de datos.
     */
    public function destroy(Imagen $imagen)
    {
        Storage::disk('public')->delete($imagen->ruta);
        $imagen->delete();

        return redirect()->route('admin.imagenes.index')->with('success', 'Imagen eliminada con éxito.');
    }
}