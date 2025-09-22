<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contacto;
use App\Models\TipoContacto;
use App\Models\DatoPersonal;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactoController extends Controller
{
    // Mapeo de claves del form => nombre en tipos_contactos
    private const CAMPOS = [
        'correo'      => 'correo',
        'telefono'    => 'telefono',
        'linkedin'    => 'linkedin',
        'google_maps' => 'google_maps',
    ];

    public function index()
    {
        // Tomamos 1 persona (o todas; ajusta según tu lógica)
        // Si manejás múltiples personas, agregá filtros/paginación.
        $personas = DatoPersonal::with(['contactos.tipoContacto'])->get();

        // Para cada persona, pivotear contactos por nombre de tipo
        $filas = $personas->map(function ($p) {
            $byTipo = $p->contactos->keyBy(fn ($c) => optional($c->tipoContacto)->nombre);
            return [
                'persona'     => $p,
                'correo'      => optional($byTipo['correo'] ?? null)->valor,
                'telefono'    => optional($byTipo['telefono'] ?? null)->valor,
                'linkedin'    => optional($byTipo['linkedin'] ?? null)->valor,
                'google_maps' => optional($byTipo['google_maps'] ?? null)->valor,
            ];
        });

        return view('admin.contactos.index', compact('filas'));
    }

    public function create()
    {
        // Si tu app asume 1 único DatoPersonal activo, podés resolverlo aquí:
        $datoPersonal = DatoPersonal::first(); // ajusta si hace falta
        return view('admin.contactos.create', compact('datoPersonal'));
    }

    public function store(Request $request)
    {
        $datoPersonalId = $request->input('dato_personal_id') ?? optional(DatoPersonal::first())->id;

        $request->validate([
            'correo'      => ['nullable', 'email'],
            'telefono'    => ['nullable', 'string', 'max:255'],
            'linkedin'    => ['nullable', 'url'],
            'google_maps' => ['nullable', 'url'],
            'dato_personal_id' => ['nullable', 'exists:datos_personales,id'],
        ]);

        foreach (self::CAMPOS as $input => $nombreTipo) {
            $valor = trim((string) $request->input($input));
            // Crear/asegurar el tipo
            $tipo = TipoContacto::firstOrCreate(['nombre' => $nombreTipo]);

            if ($valor !== '') {
                // Crear o actualizar si ya existe para esa persona + tipo
                Contacto::updateOrCreate(
                    ['dato_personal_id' => $datoPersonalId, 'tipo_contacto_id' => $tipo->id],
                    ['valor' => $valor]
                );
            } else {
                // Si vino vacío, eliminar si existía (opcional)
                Contacto::where([
                    'dato_personal_id' => $datoPersonalId,
                    'tipo_contacto_id' => $tipo->id,
                ])->delete();
            }
        }

        return redirect()->route('admin.contactos.index')->with('success', 'Contactos guardados.');
    }

    public function edit(DatoPersonal $datoPersonal)
    {
        // Cargamos los valores existentes por tipo para precargar el form
        $contactos = $datoPersonal->contactos()->with('tipoContacto')->get()->keyBy(fn ($c) => $c->tipoContacto->nombre);

        $valores = [
            'correo'      => optional($contactos['correo'] ?? null)->valor,
            'telefono'    => optional($contactos['telefono'] ?? null)->valor,
            'linkedin'    => optional($contactos['linkedin'] ?? null)->valor,
            'google_maps' => optional($contactos['google_maps'] ?? null)->valor,
        ];

        return view('admin.contactos.edit', compact('datoPersonal', 'valores'));
    }

    public function update(Request $request, DatoPersonal $datoPersonal)
    {
        $request->validate([
            'correo'      => ['nullable', 'email'],
            'telefono'    => ['nullable', 'string', 'max:255'],
            'linkedin'    => ['nullable', 'url'],
            'google_maps' => ['nullable', 'url'],
        ]);

        foreach (self::CAMPOS as $input => $nombreTipo) {
            $valor = trim((string) $request->input($input));
            $tipo  = TipoContacto::firstOrCreate(['nombre' => $nombreTipo]);

            if ($valor !== '') {
                Contacto::updateOrCreate(
                    ['dato_personal_id' => $datoPersonal->id, 'tipo_contacto_id' => $tipo->id],
                    ['valor' => $valor]
                );
            } else {
                Contacto::where([
                    'dato_personal_id' => $datoPersonal->id,
                    'tipo_contacto_id' => $tipo->id,
                ])->delete();
            }
        }

        return redirect()->route('admin.contactos.index')->with('success', 'Contactos actualizados.');
    }

    // Si querés conservar destroy de una fila suelta, podés dejarlo, pero ya no es tan necesario.
}
