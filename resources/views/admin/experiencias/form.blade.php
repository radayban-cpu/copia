@php
  // $e solo existe en edit; en create es null
  $e = $experiencia ?? null;

  // Fechas seguras (cuando $e es null) formateadas para <input type="date">
  $fecha_inicio_val = old('fecha_inicio', optional(optional($e)->fecha_inicio)->format('Y-m-d'));
  $fecha_fin_val    = old('fecha_fin',    optional(optional($e)->fecha_fin)->format('Y-m-d'));
@endphp

<div class="mb-3">
  <label class="form-label">Título</label>
  <input type="text" name="titulo"
         class="form-control @error('titulo') is-invalid @enderror"
         value="{{ old('titulo', $e->titulo ?? '') }}" required>
  @error('titulo') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Descripción</label>
  <textarea name="descripcion"
            class="form-control @error('descripcion') is-invalid @enderror"
            rows="4">{{ old('descripcion', $e->descripcion ?? '') }}</textarea>
  @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
  <div class="col-md-6 mb-3">
    <label class="form-label">Fecha inicio</label>
    <input type="date" name="fecha_inicio"
           class="form-control @error('fecha_inicio') is-invalid @enderror"
           value="{{ $fecha_inicio_val }}">
    @error('fecha_inicio') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>
  <div class="col-md-6 mb-3">
    <label class="form-label">Fecha fin</label>
    <input type="date" name="fecha_fin"
           class="form-control @error('fecha_fin') is-invalid @enderror"
           value="{{ $fecha_fin_val }}">
    @error('fecha_fin') <div class="invalid-feedback">{{ $message }}</div> @enderror
    <small class="text-muted">Dejala vacía si sigue en curso.</small>
  </div>
</div>

<div class="mb-3">
  <label class="form-label">Tipo</label>
  <select name="tipo_experiencia_id"
          class="form-select @error('tipo_experiencia_id') is-invalid @enderror"
          required>
    <option value="">-- Seleccionar --</option>
    @foreach(($tipos ?? []) as $t)
      <option value="{{ $t->id }}"
        @selected(old('tipo_experiencia_id', $e->tipo_experiencia_id ?? null) == $t->id)>
        {{ $t->nombre }}
      </option>
    @endforeach
  </select>
  @error('tipo_experiencia_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Dato personal</label>
  <input type="number" name="dato_personal_id"
         class="form-control @error('dato_personal_id') is-invalid @enderror"
         value="{{ old('dato_personal_id', $e->dato_personal_id ?? ($datoPersonal->id ?? '')) }}" required>
  <small class="text-muted">ID del registro en <code>datos_personales</code>.</small>
  @error('dato_personal_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
