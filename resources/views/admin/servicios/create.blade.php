@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Nuevo Servicio</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.servicios.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="titulo" class="form-label">Título del Servicio</label>
            <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo') }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="4" required>{{ old('descripcion') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="icono" class="form-label">Icono (Clase de Bootstrap Icons)</label>
            <input type="text" name="icono" id="icono" class="form-control" value="{{ old('icono') }}" required>
            <small class="form-text text-muted">
                Ej: <code>bi-briefcase</code>, <code>bi-card-checklist</code>. Puedes encontrar más iconos en <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a>.
            </small>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Servicio</button>
        <a href="{{ route('admin.servicios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection