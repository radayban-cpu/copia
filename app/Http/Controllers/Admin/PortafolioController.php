<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portafolio;
use App\Models\CategoriaPortafolio;
use App\Models\DatoPersonal; // <-- Importante añadirlo
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortafolioController extends Controller
{
    /**
     * Muestra una lista de proyectos del portafolio.
     */
    public function index()
    {
        $portafolios = Portafolio::with('categoria')->get();
        return view('admin.portafolios.index', compact('portafolios'));
    }

    /**
     * Muestra el formulario para crear un nuevo proyecto.
     */
    public function create()
    {
        $categorias = CategoriaPortafolio::all();
        return view('admin.portafolios.create', compact('categorias'));
    }

    /**
     * Almacena un nuevo proyecto en la base de datos y su imagen.
     */
    public function store(Request $request)
    {
        // --- INICIO DE LA ACTUALIZACIÓN ---
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'url_imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'categoria_id' => 'required|exists:categorias_portafolio,id',
        ]);

        $datoPersonal = DatoPersonal::first();
        if (!$datoPersonal) {
            return back()->withErrors(['msg' => 'Debes crear tus datos personales antes de añadir un proyecto.'])->withInput();
        }

        $path = $request->file('url_imagen')->store('portafolios', 'public');

        Portafolio::create([
            'titulo' => $validatedData['titulo'],
            'descripcion' => $validatedData['descripcion'],
            'url_imagen' => $path,
            'categoria_id' => $validatedData['categoria_id'],
            'dato_personal_id' => $datoPersonal->id, // <-- Se añade la relación
        ]);
        // --- FIN DE LA ACTUALIZACIÓN ---

        return redirect()->route('admin.portafolios.index')->with('success', 'Proyecto creado con éxito.');
    }

    /**
     * Muestra el formulario para editar un proyecto.
     */
    public function edit(Portafolio $portafolio)
    {
        $categorias = CategoriaPortafolio::all();
        return view('admin.portafolios.edit', compact('portafolio', 'categorias'));
    }

    /**
     * Actualiza un proyecto existente.
     */
    public function update(Request $request, Portafolio $portafolio)
    {
        // --- INICIO DE LA ACTUALIZACIÓN ---
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'url_imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Nullable por si no se cambia la imagen
            'categoria_id' => 'required|exists:categorias_portafolio,id',
        ]);

        if ($request->hasFile('url_imagen')) {
            Storage::disk('public')->delete($portafolio->url_imagen);
            $path = $request->file('url_imagen')->store('portafolios', 'public');
            $validatedData['url_imagen'] = $path;
        }

        $portafolio->update($validatedData);
        // --- FIN DE LA ACTUALIZACIÓN ---

        return redirect()->route('admin.portafolios.index')->with('success', 'Proyecto actualizado con éxito.');
    }

    /**
     * Elimina un proyecto.
     */
    public function destroy(Portafolio $portafolio)
    {
        Storage::disk('public')->delete($portafolio->url_imagen);
        $portafolio->delete();

        return redirect()->route('admin.portafolios.index')->with('success', 'Proyecto eliminado con éxito.');
    }
}