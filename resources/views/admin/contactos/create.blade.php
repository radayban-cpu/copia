@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Crear/Actualizar Contactos</h1>

    <form method="POST" action="{{ route('admin.contactos.store') }}">
        @csrf
        <input type="hidden" name="dato_personal_id" value="{{ optional($datoPersonal)->id }}">

        <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" name="correo" class="form-control" value="{{ old('correo') }}">
            @error('correo') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
            @error('telefono') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">LinkedIn (URL)</label>
            <input type="url" name="linkedin" class="form-control" value="{{ old('linkedin') }}">
            @error('linkedin') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Google Maps (URL)</label>
            <input type="url" name="google_maps" class="form-control" value="{{ old('google_maps') }}">
            @error('google_maps') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-primary">Guardar</button>
        <a href="{{ route('admin.contactos.index') }}" class="btn btn-link">Volver</a>
    </form>
</div>
@endsection
