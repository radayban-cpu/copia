@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Gestionar Datos de Contacto</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edita tus datos de contacto</h5>
            <p class="card-text">Rellena los campos que quieras mostrar en tu página. Si dejas un campo vacío, no se mostrará (o se eliminará si ya existía).</p>

            <form action="{{ route('admin.contactos.update') }}" method="POST">
                @csrf

                @if($tipos->isEmpty())
                    <div class="alert alert-warning">
                        No se han encontrado tipos de contacto en la base de datos. Por favor, añádelos para poder gestionar los contactos.
                    </div>
                @else
                    @foreach($tipos as $tipo)
                        <div class="mb-3">
                            <label for="contacto-{{ $tipo->id }}" class="form-label"><strong>{{ $tipo->nombre }}</strong></label>
                            <input
                                type="text"
                                name="contactos[{{ $tipo->id }}]"
                                id="contacto-{{ $tipo->id }}"
                                class="form-control"
                                value="{{ old('contactos.' . $tipo->id, $contactosActuales[$tipo->id]->valor ?? '') }}"
                                placeholder="Introduce aquí tu {{ strtolower($tipo->nombre) }}"
                            >
                        </div>
                    @endforeach
                @endif

                <button type="submit" class="btn btn-primary mt-3">Guardar Cambios</button>
            </form>
        </div>
    </div>
</div>
@endsection