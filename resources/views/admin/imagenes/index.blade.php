@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Imágenes</h2>
        <a href="{{ route('admin.imagenes.create') }}" class="btn btn-success">Subir Nueva Imagen</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @forelse($imagenes as $imagen)
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ asset('storage/' . $imagen->ruta) }}" class="card-img-top" alt="{{ $imagen->descripcion }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $imagen->descripcion }}</h5>
                    <p class="card-text"><strong>Tipo:</strong> {{ $imagen->tipo->nombre ?? 'N/A' }}</p>
                    <form action="{{ route('admin.imagenes.destroy', $imagen->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar esta imagen?')">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">No hay imágenes para mostrar. Sube una nueva imagen para empezar.</div>
        </div>
        @endforelse
    </div>
</div>
@endsection