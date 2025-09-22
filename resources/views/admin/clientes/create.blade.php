@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Nuevo Cliente</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.clientes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Cliente</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
        </div>

        <div class="mb-3">
            <label for="empresa" class="form-label">Empresa (Opcional)</label>
            <input type="text" name="empresa" id="empresa" class="form-control" value="{{ old('empresa') }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email (Opcional)</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
        </div>

        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono (Opcional)</label>
            <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono') }}">
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cliente</button>
        <a href="{{ route('admin.clientes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection