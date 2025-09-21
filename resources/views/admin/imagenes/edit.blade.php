@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Editar Imagen</h2>

    <div class="card mb-4">
        <div class="card-body text-center">
            <p class="mb-2"><strong>Imagen Actual:</strong></p>
            <img src="{{ asset('storage/' . $imagen->ruta) }}" alt="{{ $imagen->descripcion }}" class="img-fluid rounded" style="max-width: 300px;">
        </div>
    </div>

    <form action="{{ route('admin.imagenes.update', $imagen->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción (Opcional)</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ old('descripcion', $imagen->descripcion) }}">
        </div>
        <div class="mb-3">
            <label for="tipo_imagen_id" class="form-label">Tipo de Imagen</label>
            <select class="form-control" id="tipo_imagen_id" name="tipo_imagen_id" required>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo->id }}" {{ $imagen->tipo_imagen_id == $tipo->id ? 'selected' : '' }}>
                        {{ $tipo->tipo_imagen }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="{{ route('admin.imagenes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection