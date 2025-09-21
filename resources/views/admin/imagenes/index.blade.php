@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Imágenes</h2>
        <a href="{{ route('admin.imagenes.create') }}" class="btn btn-primary">Subir Nueva Imagen</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width: 15%;">Imagen</th>
                        <th>Descripción</th>
                        <th style="width: 15%;">Tipo</th>
                        <th class="text-end" style="width: 20%;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($imagenes as $imagen)
                        <tr>
                            <td>
                                <img src="{{ asset('storage/' . $imagen->ruta) }}" alt="{{ $imagen->descripcion }}" class="img-thumbnail" width="100">
                            </td>
                            <td>{{ $imagen->descripcion ?? 'Sin descripción' }}</td>
                            <td>
                                {{-- --- INICIO DE LA ACTUALIZACIÓN --- --}}
                                <span class="badge bg-secondary">{{ $imagen->tipo->tipo_imagen }}</span>
                                {{-- --- FIN DE LA ACTUALIZACIÓN --- --}}
                            </td>
                            <td class="text-end">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.imagenes.edit', $imagen->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                    <form action="{{ route('admin.imagenes.destroy', $imagen->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No hay imágenes subidas todavía.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection