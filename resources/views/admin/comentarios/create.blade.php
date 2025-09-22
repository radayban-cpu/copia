@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="mb-3">
        {{-- CORRECCIÓN AQUÍ --}}
        <a href="{{ route('admin.clientes.comentarios.index', $cliente) }}">&larr; Volver a los testimonios de {{ $cliente->nombre }}</a>
    </div>

    <h1>Nuevo Testimonio para "{{ $cliente->nombre }}"</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    {{-- CORRECCIÓN AQUÍ --}}
    <form action="{{ route('admin.clientes.comentarios.store', $cliente) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="contenido" class="form-label">Contenido del Testimonio</label>
            <textarea name="contenido" id="contenido" class="form-control" rows="5" required>{{ old('contenido') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Testimonio</button>
        {{-- CORRECCIÓN AQUÍ --}}
        <a href="{{ route('admin.clientes.comentarios.index', $cliente) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection