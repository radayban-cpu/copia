@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Portafolio</h2>
        <a href="{{ route('admin.portafolios.create') }}" class="btn btn-success">Añadir Nuevo Proyecto</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Título</th>
                    <th>Cliente</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($portafolios as $portafolio)
                <tr>
                    <td><img src="{{ asset('storage/' . $portafolio->url_imagen) }}" alt="{{ $portafolio->titulo }}" width="100"></td>
                    <td>{{ $portafolio->titulo }}</td>
                    <td>{{ $portafolio->cliente }}</td>
                    <td>{{ $portafolio->categoria->nombre ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('admin.portafolios.edit', $portafolio->id) }}" class="btn btn-primary btn-sm">Editar</a>
                        <form action="{{ route('admin.portafolios.destroy', $portafolio->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar este proyecto?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No hay proyectos para mostrar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection