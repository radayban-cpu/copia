{{-- resources/views/inicio.blade.php --}}

@php
    // --- INICIO DE LA ACTUALIZACIÓN ---

    // Asignar el dato personal para usarlo en la vista
    $datos = $datos ?? ($datoPersonal ?? null);

    // Determinar la URL de la imagen de Perfil
    // Si la variable $imagenPerfil existe (vino del controller), usa su ruta.
    // Si no, usa una imagen por defecto.
    $urlImagenPerfil = isset($imagenPerfil) && !empty($imagenPerfil->ruta)
        ? asset('storage/' . $imagenPerfil->ruta)
        : null; // Opcional: asset('assets/img/logo-default.png') si quieres un logo por defecto

    // Determinar la URL de la imagen de Muro
    // Si la variable $imagenMuro existe, usa su ruta.
    // Si no, usa una imagen por defecto.
    $urlImagenMuro = isset($imagenMuro) && !empty($imagenMuro->ruta)
        ? asset('storage/' . $imagenMuro->ruta)
        : asset('assets/img/hero-bg.jpg'); // Imagen de fondo por defecto

    // Ítems para el efecto de texto animado (typed.js)
    $typedItems = collect([
        optional($datos)->carrera,
        optional($datos)->frase,
    ])->filter()->implode(', ');

    // --- FIN DE LA ACTUALIZACIÓN ---
@endphp

<x-layout />

<header id="header" class="header d-flex align-items-center light-background sticky-top">
  <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

    <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto me-xl-0">
      {{-- Logo dinámico --}}
      @if($urlImagenPerfil)
        <img src="{{ $urlImagenPerfil }}" alt="Foto de perfil">
      @else
        {{-- Si no hay imagen de perfil, muestra el nombre --}}
        <h1 class="sitename">{{ optional($datos)->nombre ?? 'Inicio' }}</h1>
      @endif
    </a>

    <x-nav-bar />

    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>

    {{-- Redes sociales (puedes hacerlas dinámicas en el futuro) --}}
    <div class="header-social-links">
      <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
      <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
      <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
      <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
    </div>

  </div>
</header>

<main class="main">

  <section id="hero" class="hero section">
    {{-- Imagen de muro dinámica con fallback --}}
    <img src="{{ $urlImagenMuro }}" alt="Imagen de portada" data-aos="fade-in">

    <div class="container text-center" data-aos="zoom-out" data-aos-delay="100">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          @if($datos)
            <h2>{{ $datos->nombre }} {{ $datos->apellido }}</h2>
            <p>
              Soy
              <span class="typed" data-typed-items="{{ $typedItems }}"></span>
            </p>
            <a href="{{ route('acerca') }}" class="btn-get-started">Sobre mí</a>
          @else
            <h2>¡Bienvenido!</h2>
            <p>Aún no hay datos personales para mostrar. Por favor, añádelos en el panel de administración.</p>
            <a href="{{ route('acerca') }}" class="btn-get-started">Sobre mí</a>
          @endif
        </div>
      </div>
    </div>
  </section>
</main>

<x-footer />

{{-- Botón para volver arriba --}}
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
  <i class="bi bi-arrow-up-short"></i>
</a>

{{-- Preloader --}}
<div id="preloader"></div>
