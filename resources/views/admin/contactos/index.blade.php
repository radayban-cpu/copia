@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Contactos</h1>

    <a href="{{ route('admin.contactos.create') }}" class="btn btn-primary mb-3">Crear/Actualizar Contactos</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Persona</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>LinkedIn</th>
                <th>Google Maps</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($filas as $f)
                <tr>
                    <td>{{ $f['persona']->nombre }} {{ $f['persona']->apellido }}</td>
                    <td>{{ $f['correo'] ?? '—' }}</td>
                    <td>{{ $f['telefono'] ?? '—' }}</td>
                    <td>
                        @if(!empty($f['linkedin']))
                            <a href="{{ $f['linkedin'] }}" target="_blank">Perfil</a>
                        @else
                            —
                        @endif
                    </td>
                    <td>
                        @if(!empty($f['google_maps']))
                            <a href="{{ $f['google_maps'] }}" target="_blank">Mapa</a>
                        @else
                            —
                        @endif
                    </td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-secondary"
                           href="{{ route('admin.contactos.edit', $f['persona']) }}">
                           Editar
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Sin datos</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
