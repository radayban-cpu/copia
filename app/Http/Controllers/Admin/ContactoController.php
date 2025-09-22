<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contacto;
use App\Models\TipoContacto;
use App\Models\DatoPersonal;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    /**
     * Muestra una lista de todos los contactos.
     */
    public function index()
    {
        $contactos = Contacto::with('tipo')->latest()->get();
        return view('admin.contactos.index', compact('contactos'));
    }

    /**
     * Muestra el formulario para crear un nuevo contacto.
     */
    public function create()
    {
        $tipos = TipoContacto::orderBy('nombre')->get();
        return view('admin.contactos.create', compact('tipos'));
    }

    /**
     * Guarda un nuevo contacto en la base de datos.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'valor'            => 'required|string|max:255',
            'tipo_contacto_id' => 'required|exists:tipos_contactos,id',
        ]);

        $datoPersonal = DatoPersonal::firstOrFail();
        $datoPersonal->contactos()->create($data);

        return redirect()->route('admin.contactos.index')->with('success', 'Contacto creado.');
    }

    /**
     * Muestra el formulario para editar un contacto existente.
     */
    public function edit(Contacto $contacto)
    {
        $tipos = TipoContacto::orderBy('nombre')->get();
        return view('admin.contactos.edit', compact('contacto', 'tipos'));
    }

    /**
     * Actualiza un contacto existente en la base de datos.
     */
    public function update(Request $request, Contacto $contacto)
    {
        $data = $request->validate([
            'valor'            => 'required|string|max:255',
            'tipo_contacto_id' => 'required|exists:tipos_contactos,id',
        ]);

        $contacto->update($data);

        return redirect()->route('admin.contactos.index')->with('success', 'Contacto actualizado.');
    }

    /**
     * Elimina un contacto de la base de datos.
     */
    public function destroy(Contacto $contacto)
    {
        $contacto->delete();
        return redirect()->route('admin.contactos.index')->with('success', 'Contacto eliminado.');
    }
}