<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experiencia;
use App\Models\TipoExperiencia;
use App\Models\DatoPersonal;
use Illuminate\Http\Request;

class ExperienciaController extends Controller
{
    public function index()
    {
        $experiencias = Experiencia::with('tipo')->latest('fecha_inicio')->paginate(15);
        return view('admin.experiencias.index', compact('experiencias'));
    }

    public function create()
    {
        $tipos = TipoExperiencia::orderBy('nombre')->get();
        $datoPersonal = DatoPersonal::first();
        return view('admin.experiencias.create', compact('tipos','datoPersonal'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'              => 'required|string|max:255',
            'descripcion'         => 'nullable|string',
            'fecha_inicio'        => 'nullable|date',
            'fecha_fin'           => 'nullable|date|after_or_equal:fecha_inicio',
            'tipo_experiencia_id' => 'required|exists:tipos_experiencias,id',
            'dato_personal_id'    => 'required|exists:datos_personales,id',
        ]);

        Experiencia::create($data);
        return redirect()->route('admin.experiencias.index')->with('success', 'Experiencia creada.');
    }

    public function edit(Experiencia $experiencia)
    {
        $tipos = TipoExperiencia::orderBy('nombre')->get();
        $datoPersonal = DatoPersonal::first();
        return view('admin.experiencias.edit', compact('experiencia','tipos','datoPersonal'));
    }

    public function update(Request $request, Experiencia $experiencia)
    {
        $data = $request->validate([
            'titulo'              => 'required|string|max:255',
            'descripcion'         => 'nullable|string',
            'fecha_inicio'        => 'nullable|date',
            'fecha_fin'           => 'nullable|date|after_or_equal:fecha_inicio',
            'tipo_experiencia_id' => 'required|exists:tipos_experiencias,id',
            'dato_personal_id'    => 'required|exists:datos_personales,id',
        ]);

        $experiencia->update($data);
        return redirect()->route('admin.experiencias.index')->with('success', 'Experiencia actualizada.');
    }

    public function destroy(Experiencia $experiencia)
    {
        $experiencia->delete();
        return redirect()->route('admin.experiencias.index')->with('success', 'Experiencia eliminada.');
    }
}
