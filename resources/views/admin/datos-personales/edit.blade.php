@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Editar Datos Personales</h2>
    </div>

    <form action="{{ route('admin.datos-personales.update', $dato_personal->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="{{ old('titulo', $dato_personal->titulo) }}" required>
        </div>
        <div class="mb-3">
            <label for="subtitulo" class="form-label">Subtítulo</label>
            <input type="text" class="form-control" id="subtitulo" name="subtitulo" value="{{ old('subtitulo', $dato_personal->subtitulo) }}" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="5" required>{{ old('descripcion', $dato_personal->descripcion) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="ciudad" class="form-label">Ciudad</label>
            <input type="text" class="form-control" id="ciudad" name="ciudad" value="{{ old('ciudad', $dato_personal->ciudad) }}" required>
        </div>
        <div class="mb-3">
            <label for="edad" class="form-label">Edad</label>
            <input type="number" class="form-control" id="edad" name="edad" value="{{ old('edad', $dato_personal->edad) }}" required>
        </div>
        <div class="mb-3">
            <label for="carrera" class="form-label">Carrera</label>
            <input type="text" class="form-control" id="carrera" name="carrera" value="{{ old('carrera', $dato_personal->carrera) }}" required>
        </div>
        <div class="mb-3">
            <label for="frase" class="form-label">Frase</label>
            <input type="text" class="form-control" id="frase" name="frase" value="{{ old('frase', $dato_personal->frase) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="{{ route('admin.datos-personales.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection