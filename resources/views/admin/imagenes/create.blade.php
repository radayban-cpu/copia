@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Subir Nueva Imagen</h2>
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

    <form action="{{ route('admin.imagenes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="imagen" class="form-label">Archivo de Imagen</label>
            <input class="form-control" type="file" id="imagen" name="imagen" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
        </div>
        <div class="mb-3">
            <label for="tipo_imagen_id" class="form-label">Tipo de Imagen</label>
            <select class="form-control" id="tipo_imagen_id" name="tipo_imagen_id" required>
                <option value="">Selecciona un tipo</option>
                {{-- Aquí deberías iterar sobre los tipos de imágenes desde la base de datos --}}
                <option value="1">Perfil</option>
                <option value="2">Muro</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Subir Imagen</button>
        <a href="{{ route('admin.imagenes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection