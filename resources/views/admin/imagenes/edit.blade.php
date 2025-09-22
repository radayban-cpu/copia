@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Editar Imagen</h1>

    {{-- Mostrar errores de validación si existen --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario de actualización --}}
    <form action="{{ route('admin.imagenes.update', $imagen) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="descripcion">Descripción</label>
            <input
                type="text"
                name="descripcion"
                id="descripcion"
                class="form-control"
                value="{{ old('descripcion', $imagen->descripcion) }}"
            >
        </div>

        <div class="form-group mb-3">
            <label for="tipo_imagen_id">Tipo de Imagen</label>
            <select name="tipo_imagen_id" id="tipo_imagen_id" class="form-control" required>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo->id }}" {{ (old('tipo_imagen_id', $imagen->tipo_imagen_id) == $tipo->id) ? 'selected' : '' }}>
                        {{ $tipo->tipo_imagen }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="ruta">Cambiar Imagen (Opcional)</label>
            <input type="file" name="ruta" id="ruta" class="form-control">

            {{-- Mostrar la imagen actual --}}
            @if($imagen->ruta)
                <div class="mt-2">
                    <p>Imagen actual:</p>
                    <img src="{{ asset('storage/' . $imagen->ruta) }}" alt="Imagen actual" style="max-width: 200px; height: auto;">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Imagen</button>
        <a href="{{ route('admin.imagenes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
