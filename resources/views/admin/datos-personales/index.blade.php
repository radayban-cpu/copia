@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Mis Datos Personales</h2>
        @if($datos)
            <a href="{{ route('admin.datos-personales.edit', $datos->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil-square"></i> Editar Datos
            </a>
        @endif
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($datos)
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h5 class="card-title">{{ $datos->nombre }} {{ $datos->apellido }}</h5>
                        {{-- --- INICIO DE LA ACTUALIZACIÓN --- --}}
                        <h6 class="card-subtitle mb-2 text-muted">{{ $datos->carrera }}</h6>
                        <p class="card-text mt-3"><strong>Descripción:</strong> {{ $datos->descripcion }}</p>
                        <p class="card-text"><strong>Frase:</strong> <em>"{{ $datos->frase }}"</em></p>
                        {{-- --- FIN DE LA ACTUALIZACIÓN --- --}}
                    </div>
                    <div class="col-md-4">
                        <ul class="list-group list-group-flush">
                            {{-- --- INICIO DE LA ACTUALIZACIÓN --- --}}
                            <li class="list-group-item"><strong>Edad:</strong> {{ $datos->edad }}</li>
                            <li class="list-group-item"><strong>Fecha de Nacimiento:</strong> {{ $datos->fecha_nacimiento }}</li>
                            <li class="list-group-item"><strong>Ciudad:</strong> {{ $datos->ciudad_domicilio }}</li>
                            {{-- --- FIN DE LA ACTUALIZACIÓN --- --}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            No hay datos personales para mostrar. Por favor, créalos primero.
        </div>
    @endif
</div>
@endsection