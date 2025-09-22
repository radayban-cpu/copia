@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Contactos</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.contactos.create') }}" class="btn btn-primary mb-3">Nuevo Contacto</a>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Valor</th>
                <th style="width: 190px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($contactos as $contacto)
                <tr>
                    <td>{{ $contacto->tipo->nombre ?? 'N/A' }}</td>
                    <td>{{ $contacto->valor }}</td>
                    <td>
                        <a href="{{ route('admin.contactos.edit', $contacto) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('admin.contactos.destroy', $contacto) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este contacto?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No hay contactos cargados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection