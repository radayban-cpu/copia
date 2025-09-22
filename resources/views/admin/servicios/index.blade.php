@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Servicios</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.servicios.create') }}" class="btn btn-primary mb-3">Nuevo Servicio</a>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Icono</th>
                <th>Título</th>
                <th>Descripción</th>
                <th style="width: 190px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($servicios as $servicio)
                <tr>
                    <td><i class="bi {{ $servicio->icono }}"></i> ({{ $servicio->icono }})</td>
                    <td>{{ $servicio->titulo }}</td>
                    <td>{{ Str::limit($servicio->descripcion, 80) }}</td>
                    <td>
                        <a href="{{ route('admin.servicios.edit', $servicio) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('admin.servicios.destroy', $servicio) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este servicio?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No hay servicios cargados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection