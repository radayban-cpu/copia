@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Editar Datos Personales</h2>
    <form action="{{ route('admin.datos-personales.update', $dato_personal->id) }}" method="POST">
        @csrf
        @method('PUT')
        {{-- Campos existentes --}}
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $dato_personal->nombre) }}" required>
        </div>
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido" value="{{ old('apellido', $dato_personal->apellido) }}" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción (máx. 125 caracteres)</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required>{{ old('descripcion', $dato_personal->descripcion) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $dato_personal->fecha_nacimiento) }}" required>
        </div>
        <div class="mb-3">
            <label for="ciudad_domicilio" class="form-label">Ciudad de Domicilio</label>
            <input type="text" class="form-control" id="ciudad_domicilio" name="ciudad_domicilio" value="{{ old('ciudad_domicilio', $dato_personal->ciudad_domicilio) }}" required>
        </div>

        {{-- --- INICIO DE LA ACTUALIZACIÓN --- --}}
        <div class="mb-3">
            <label for="carrera" class="form-label">Carrera (Opcional)</label>
            <input type="text" class="form-control" id="carrera" name="carrera" value="{{ old('carrera', $dato_personal->carrera) }}">
        </div>
        <div class="mb-3">
            <label for="frase" class="form-label">Frase (Opcional)</label>
            <input type="text" class="form-control" id="frase" name="frase" value="{{ old('frase', $dato_personal->frase) }}">
        </div>
        <div class="mb-3">
            <label for="edad" class="form-label">Edad (Opcional)</label>
            <input type="number" class="form-control" id="edad" name="edad" value="{{ old('edad', $dato_personal->edad) }}">
        </div>
        {{-- --- FIN DE LA ACTUALIZACIÓN --- --}}

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="{{ route('admin.datos-personales.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection