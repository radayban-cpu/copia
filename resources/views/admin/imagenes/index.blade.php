@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Gestión de Imágenes</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.imagenes.create') }}" class="btn btn-primary mb-3">Subir Nueva Imagen</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Imagen</th>
                <th>Descripción</th>
                <th>Tipo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($imagenes as $imagen)
                <tr>
                    <td>{{ $imagen->id }}</td>
                    <td>
                        @if($imagen->ruta)
                            <img src="{{ asset('storage/' . $imagen->ruta) }}" alt="Imagen" width="100">
                        @else
                            Sin imagen
                        @endif
                    </td>
                    <td>{{ $imagen->descripcion ?? 'N/A' }}</td>
                    <td>{{ $imagen->tipo->tipo_imagen ?? 'Desconocido' }}</td>
                    <td>
                        {{-- --- INICIO DE LA ACTUALIZACIÓN --- --}}
                        {{-- Usamos $imagen->id para generar las rutas correctas --}}
                        <a href="{{ route('admin.imagenes.edit', $imagen->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        
                        <form action="{{ route('admin.imagenes.destroy', $imagen->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta imagen?')">Eliminar</button>
                        </form>
                        {{-- --- FIN DE LA ACTUALIZACIÓN --- --}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No hay imágenes para mostrar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
