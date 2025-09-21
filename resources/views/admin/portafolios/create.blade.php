@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Añadir Nuevo Proyecto al Portafolio</h2>

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <strong>¡Vaya! Hubo algunos problemas:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.portafolios.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="titulo" class="form-label">Título del Proyecto</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="{{ old('titulo') }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="5" required>{{ old('descripcion') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="url_imagen" class="form-label">Imagen Principal del Proyecto</label>
            <input class="form-control" type="file" id="url_imagen" name="url_imagen" required>
        </div>

        {{-- --- INICIO DE LA ACTUALIZACIÓN --- --}}
        <div class="mb-3">
            <label for="categoria_id" class="form-label">Categoría</label>
            <select class="form-control" id="categoria_id" name="categoria_id" required>
                <option value="">Selecciona una categoría</option>
                {{-- Este bucle carga las categorías que le pasamos desde el controlador --}}
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        {{-- --- FIN DE LA ACTUALIZACIÓN --- --}}
        
        <button type="submit" class="btn btn-primary">Guardar Proyecto</button>
        <a href="{{ route('admin.portafolios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection