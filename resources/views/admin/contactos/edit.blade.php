@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Editar Contacto</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.contactos.update', $contacto) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="tipo_contacto_id" class="form-label">Tipo de Contacto</label>
            <select name="tipo_contacto_id" id="tipo_contacto_id" class="form-control" required>
                <option value="" hidden>Selecciona un tipo...</option>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo->id }}" @selected(old('tipo_contacto_id', $contacto->tipo_contacto_id) == $tipo->id)>
                        {{ $tipo->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="valor" class="form-label">Valor</label>
            <input type="text" name="valor" id="valor" class="form-control" value="{{ old('valor', $contacto->valor) }}" required>
            <small class="form-text text-muted">
                Ej: "tucorreo@dominio.com", "+595 981 123456", etc.
            </small>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Contacto</button>
        <a href="{{ route('admin.contactos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection