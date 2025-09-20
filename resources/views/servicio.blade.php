@extends('layouts.app')

@section('title', 'Servicios - Mi Sitio')
@section('body-class', 'services-page')

@section('content')
    <section id="services" class="services section">
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2>Servicios</h2>
        <p>Estos son los servicios que ofrezco para ayudarte a destacar.</p>
      </div>

      <div class="row gy-4">
        @if($servicios && $servicios->count() > 0)
          @foreach($servicios as $index => $servicio)
            {{--
              - Quitamos 'd-flex' y 'align-items-stretch' de aquí.
              - La magia la hará la clase 'h-100' en el div de abajo.
            --}}
          <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="{{ ($index % 3 + 1) * 100 }}">
              {{-- AÑADIMOS LA CLASE 'h-100' (height: 100%) A LA TARJETA --}}
            <div class="icon-box h-100">
              <div class="icon"><i class="{{ $servicio->icono }}"></i></div>
              <h4><a href="">{{ $servicio->titulo }}</a></h4>
              <p>{{ $servicio->descripcion }}</p>
            </div>
          </div>
          @endforeach
        @else
          <p>Actualmente no hay servicios para mostrar.</p>
        @endif
      </div>

    </div>
  </section>@endsection