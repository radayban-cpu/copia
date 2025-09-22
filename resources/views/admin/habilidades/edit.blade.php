@extends('admin.layouts.app')

@section('content')
<div class="container">
  <h1>Editar Habilidad</h1>

  @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  {{-- Avisos sobre la tabla de tipos --}}
  @if (!$tiposHabilitados)
    <div class="alert alert-warning">
      La tabla <code>tipos_habilidades</code> no existe. Puedes crearla/migrarla y recargar esta página.
      Mientras tanto, el campo “Tipo” se deshabilita, pero se mantendrá el valor actual.
    </div>
  @elseif ($tipos->isEmpty())
    <div class="alert alert-info">
      No hay tipos de habilidades cargados todavía. Agrega algunos en la tabla <code>tipos_habilidades</code>.
      Mientras tanto, se mantendrá el valor actual.
    </div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <form action="{{ route('admin.habilidades.update', $habilidad) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label class="form-label">Nombre</label>
      <input
        type="text"
        name="nombre"
        class="form-control"
        value="{{ old('nombre', $habilidad->nombre) }}"
        required
      >
    </div>

    <div class="mb-3">
      <label class="form-label">Nivel (0-100)</label>
      <input
        type="number"
        name="nivel"
        class="form-control"
        min="0"
        max="100"
        value="{{ old('nivel', $habilidad->nivel) }}"
      >
    </div>

    <div class="mb-3">
      <label class="form-label">Tipo</label>

      @php
        $valorTipoActual = old('tipo_habilidad_id', $habilidad->tipo_habilidad_id);
        $habilitarSelect = $tiposHabilitados && $tipos->isNotEmpty();
      @endphp

      <select
        name="tipo_habilidad_id"
        class="form-control"
        {{ $habilitarSelect ? 'required' : 'disabled' }}
      >
