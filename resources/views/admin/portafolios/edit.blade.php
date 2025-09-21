@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Editar Proyecto</h2>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.portafolios.update', $portafolio->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="{{ old('titulo', $portafolio->titulo) }}" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="5" required>{{ old('descripcion', $portafolio->descripcion) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="cliente" class="form-label">Cliente</label>
            <input type="text" class="form-control" id="cliente" name="cliente" value="{{ old('cliente', $portafolio->cliente) }}" required>
        </div>
        <div class="mb-3">
            <label for="url_proyecto" class="form-label">URL del Proyecto</label>
            <input type="url" class="form-control" id="url_proyecto" name="url_proyecto" value="{{ old('url_proyecto', $portafolio->url_proyecto) }}">
        </div>
        <div class="mb-3">
            <label for="url_imagen" class="form-label">Imagen del Proyecto</label>
            <input class="form-control" type="file" id="url_imagen" name="url_imagen">
            @if($portafolio->url_imagen)
                <small class="text-muted d-block mt-2">Imagen actual:</small>
                <img src="{{ asset('storage/' . $portafolio->url_imagen) }}" alt="{{ $portafolio->titulo }}" width="150" class="mt-1">
            @endif
        </div>
        <div class="mb-3">
            <label for="categoria_id" class="form-label">Categoría</label>
            <select class="form-control" id="categoria_id" name="categoria_id" required>
                <option value="">Selecciona una categoría</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ old('categoria_id', $portafolio->categoria_id) == $categoria->id ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="{{ route('admin.portafolios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection