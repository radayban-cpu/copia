@extends('admin.layout')

@section('content')
  <h1>Experiencias</h1>
  <a href="{{ route('admin.experiencias.create') }}" class="btn btn-primary mb-3">Nueva experiencia</a>

  <table class="table table-striped">
    <thead>
      <tr>
        <th>Título</th>
        <th>Tipo</th>
        <th>Inicio</th>
        <th>Fin</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @forelse($experiencias as $e)
        <tr>
          <td>{{ $e->titulo }}</td>
          <td>{{ $e->tipo->nombre ?? '—' }}</td>
          <td>{{ $e->fecha_inicio ? $e->fecha_inicio->format('Y-m-d') : '—' }}</td>
          <td>{{ $e->fecha_fin ? $e->fecha_fin->format('Y-m-d') : 'Actual' }}</td>
          <td class="text-end">
            <a href="{{ route('admin.experiencias.edit', $e) }}" class="btn btn-sm btn-warning">Editar</a>
            <form action="{{ route('admin.experiencias.destroy', $e) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('¿Eliminar experiencia?');">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger">Eliminar</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="5" class="text-center text-muted">No hay experiencias.</td></tr>
      @endforelse
    </tbody>
  </table>

  {{ $experiencias->links() }}
@endsection
