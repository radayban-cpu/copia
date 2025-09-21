@extends('admin.layout')

@section('content')
  <h1>Nueva experiencia</h1>

  {{-- Mensajes / Errores --}}
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if($errors->any())
    <div class="alert alert-danger">
      <strong>Por favor corrige los siguientes errores:</strong>
      <ul class="mb-0">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.experiencias.store') }}" method="POST">
    @csrf
    @include('admin.experiencias.form')
    <button class="btn btn-primary">Guardar</button>
    <a href="{{ route('admin.experiencias.index') }}" class="btn btn-secondary">Cancelar</a>
  </form>
@endsection
