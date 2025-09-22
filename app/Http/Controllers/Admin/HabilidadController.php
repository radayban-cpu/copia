<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Habilidad;
use App\Models\TipoHabilidad;
use App\Models\DatoPersonal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class HabilidadController extends Controller
{
    public function index()
    {
        $dato = DatoPersonal::first();

        $habilidades = Habilidad::with('tipo')
            ->when($dato, fn($q) => $q->where('dato_personal_id', $dato->id))
            ->orderBy('tipo_habilidad_id')
            ->orderBy('nombre')
            ->get();

        return view('admin.habilidades.index', compact('habilidades', 'dato'));
    }

    public function create()
    {
        $dato = DatoPersonal::first();
        if (!$dato) {
            return redirect()->route('admin.habilidades.index')
                ->with('error', 'Primero crea tu Dato Personal.');
        }

        // <- ESTA ES LA CLAVE: no intentamos consultar si no existe la tabla
        $tipos = Schema::hasTable('tipos_habilidades')
            ? TipoHabilidad::orderBy('nombre')->get()
            : collect();

        $tiposHabilitados = Schema::hasTable('tipos_habilidades');

        return view('admin.habilidades.create', compact('dato', 'tipos', 'tiposHabilitados'));
    }

    public function store(Request $request)
    {
        $dato = DatoPersonal::firstOrFail();

        $rules = [
            'nombre'            => 'required|string|max:255',
            'nivel'             => 'nullable|integer|min:0|max:100',
            'tipo_habilidad_id' => 'required|exists:tipos_habilidades,id',
        ];

        // Si no existe la tabla de tipos, evitamos el validador exists para que no explote
        if (!Schema::hasTable('tipos_habilidades')) {
            unset($rules['tipo_habilidad_id']);
            $request->merge(['tipo_habilidad_id' => null]);
        }

        $data = $request->validate($rules);
        $data['dato_personal_id'] = $dato->id;

        Habilidad::create($data);

        return redirect()->route('admin.habilidades.index')->with('success', 'Habilidad creada.');
    }

    public function edit(Habilidad $habilidad)
    {
        $dato  = DatoPersonal::first();

        $tipos = Schema::hasTable('tipos_habilidades')
            ? TipoHabilidad::orderBy('nombre')->get()
            : collect();

        $tiposHabilitados = Schema::hasTable('tipos_habilidades');

        return view('admin.habilidades.edit', compact('habilidad', 'dato', 'tipos', 'tiposHabilitados'));
    }

    public function update(Request $request, Habilidad $habilidad)
    {
        $rules = [
            'nombre'            => 'required|string|max:255',
            'nivel'             => 'nullable|integer|min:0|max:100',
            'tipo_habilidad_id' => 'required|exists:tipos_habilidades,id',
        ];

        if (!Schema::hasTable('tipos_habilidades')) {
            unset($rules['tipo_habilidad_id']);
            $request->merge(['tipo_habilidad_id' => $habilidad->tipo_habilidad_id]); // deja el que tenía
        }

        $data = $request->validate($rules);

        $habilidad->update($data);

        return redirect()->route('admin.habilidades.index')->with('success', 'Habilidad actualizada.');
    }

    public function destroy(Habilidad $habilidad)
    {
        $habilidad->delete();
        return redirect()->route('admin.habilidades.index')->with('success', 'Habilidad eliminada.');
    }
}
