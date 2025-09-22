@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Testimonios / Clientes</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.clientes.create') }}" class="btn btn-primary mb-3">Nuevo Cliente</a>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Empresa</th>
                <th>Testimonios</th>
                <th style="width: 280px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->nombre }}</td>
                    <td>{{ $cliente->empresa ?? '—' }}</td>
                    <td>{{ $cliente->comentarios_count }}</td>
                    <td>
                        {{-- CORRECCIÓN AQUÍ --}}
                        <a href="{{ route('admin.clientes.comentarios.index', $cliente) }}" class="btn btn-sm btn-info">Ver Testimonios</a>
                        <a href="{{ route('admin.clientes.edit', $cliente) }}" class="btn btn-sm btn-warning">Editar Cliente</a>
                        <form action="{{ route('admin.clientes.destroy', $cliente) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este cliente y todos sus testimonios?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No hay clientes cargados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection