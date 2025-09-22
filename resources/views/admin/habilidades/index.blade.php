@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Habilidades</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('admin.habilidades.create') }}" class="btn btn-primary mb-3">Nueva Habilidad</a>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Nombre</th>
                <th>Nivel</th>
                <th style="width: 190px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($habilidades as $h)
                <tr>
                    {{-- CORRECCIÓN AQUÍ --}}
                    <td>{{ $h->tipo->nombre_habilidad ?? '—' }}</td>
                    <td>{{ $h->nombre }}</td>
                    <td>{{ $h->nivel ?? 0 }}%</td>
                    <td>
                        <a href="{{ route('admin.habilidades.edit', $h) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('admin.habilidades.destroy', $h) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar habilidad?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">Sin habilidades aún.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection