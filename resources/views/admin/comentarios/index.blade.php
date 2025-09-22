@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="mb-3">
        <a href="{{ route('admin.clientes.index') }}">&larr; Volver a la lista de clientes</a>
    </div>

    <h1>Testimonios de "{{ $cliente->nombre }}"</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- CORRECCIÓN AQUÍ --}}
    <a href="{{ route('admin.clientes.comentarios.create', $cliente) }}" class="btn btn-primary mb-3">Nuevo Testimonio</a>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Contenido del Testimonio</th>
                <th style="width: 190px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($comentarios as $comentario)
                <tr>
                    <td>{!! nl2br(e($comentario->contenido)) !!}</td>
                    <td>
                        <a href="{{ route('admin.comentarios.edit', $comentario) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('admin.comentarios.destroy', $comentario) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este testimonio?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-center">Este cliente aún no tiene testimonios.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection