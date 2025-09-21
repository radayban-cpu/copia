@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Datos Personales</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($datos)
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            Información del Perfil
            <a href="{{ route('admin.datos-personales.edit', $datos->id) }}" class="btn btn-primary">Editar</a>
        </div>
        <div class="card-body">
            <p><strong>Título:</strong> {{ $datos->titulo }}</p>
            <p><strong>Subtítulo:</strong> {{ $datos->subtitulo }}</p>
            <p><strong>Descripción:</strong> {{ $datos->descripcion }}</p>
            <p><strong>Ciudad:</strong> {{ $datos->ciudad }}</p>
            <p><strong>Edad:</strong> {{ $datos->edad }}</p>
            <p><strong>Carrera:</strong> {{ $datos->carrera }}</p>
            <p><strong>Frase:</strong> {{ $datos->frase }}</p>
        </div>
    </div>
    @else
    <div class="alert alert-warning">No se encontraron datos personales. Por favor, crea un registro para comenzar.</div>
    <a href="{{ route('admin.datos-personales.create') }}" class="btn btn-success">Crear Datos Personales</a>
    @endif
</div>
@endsection