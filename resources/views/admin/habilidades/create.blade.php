@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Nueva Habilidad</h1>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if (!$tiposHabilitados)
        <div class="alert alert-warning">
            La tabla <code>tipos_habilidades</code> no existe. Puedes crearla/migrarla y recargar esta página.
            Mientras tanto, el campo “Tipo” se deshabilita.
        </div>
    @elseif ($tipos->isEmpty())
        <div class="alert alert-info">
            No hay tipos de habilidades cargados todavía. Agrega algunos en la tabla <code>tipos_habilidades</code>.
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.habilidades.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nivel (0-100)</label>
            <input type="number" name="nivel" class="form-control" min="0" max="100" value="{{ old('nivel', 50) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Tipo</label>
            @php
                $habilitarSelect = $tiposHabilitados && $tipos->isNotEmpty();
            @endphp
            <select
                name="tipo_habilidad_id"
                class="form-control"
                {{ $habilitarSelect ? 'required' : 'disabled' }}
            >
                @if($habilitarSelect)
                    <option value="" hidden>Selecciona un tipo…</option>
                    @foreach($tipos as $t)
                        <option value="{{ $t->id }}" @selected(old('tipo_habilidad_id') == $t->id)>
                            {{-- CORRECCIÓN AQUÍ --}}
                            {{ $t->nombre_habilidad }}
                        </option>
                    @endforeach
                @else
                    <option value="" selected>No disponible</option>
                @endif
            </select>
            @unless($habilitarSelect)
                <small class="text-muted">Guarda luego de crear los tipos o habilita la tabla.</small>
            @endunless
        </div>

        <button class="btn btn-primary">Guardar</button>
        <a href="{{ route('admin.habilidades.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection