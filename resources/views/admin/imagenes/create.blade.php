@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Subir Nueva Imagen</h2>

    {{-- Bloque para mostrar errores de validación generales --}}
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

    {{-- Bloque para mostrar el error específico de "Datos Personales" --}}
    @if (session('error'))
        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.imagenes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="ruta" class="form-label">Archivo de Imagen</label>
            <input class="form-control" type="file" id="ruta" name="ruta" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción (Opcional)</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ old('descripcion') }}">
        </div>
        <div class="mb-3">
            <label for="tipo_imagen_id" class="form-label">Tipo de Imagen</label>
            <select class="form-control" id="tipo_imagen_id" name="tipo_imagen_id" required>
                <option value="">Selecciona un tipo</option>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo->id }}">{{ $tipo->tipo_imagen }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Subir Imagen</button>
        <a href="{{ route('admin.imagenes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection