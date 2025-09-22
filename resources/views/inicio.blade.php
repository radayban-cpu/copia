{{-- resources/views/inicio.blade.php --}}

@php
    // --- INICIO DE LA ACTUALIZACIÓN ---

    $datos = $datos ?? ($datoPersonal ?? null);

    // Perfil: aunque exista imagen, no la usaremos (mostramos nombre en el header)
    $urlImagenPerfil = null;

    // Muro dinámico con fallback
    if (is_string($imagenMuro ?? null)) {
        $urlImagenMuro = $imagenMuro;
    } elseif (!empty($imagenMuro->ruta ?? null)) {
        $urlImagenMuro = asset('storage/' . $imagenMuro->ruta);
    } else {
        $urlImagenMuro = asset('assets/img/hero-bg.jpg');
    }

    // Frases para typed.js (si quieres volver a activarlo después)
    $typedItems = collect([
        optional($datos)->carrera,
        optional($datos)->frase,
    ])->filter()->implode(', ');
@endphp

<x-layout />

<header id="header" class="header d-flex align-items-center light-background sticky-top">
  <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

    <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto me-xl-0">
      {{-- Siempre nombre (ya no imagen) --}}
      <h1 class="sitename">{{ optional($datos)->nombre ?? 'Inicio' }}</h1>
    </a>

    <x-nav-bar />

    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>

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
    {{-- Imagen de muro --}}
    <img id="hero-bg" src="{{ $urlImagenMuro }}" alt="Imagen de portada" data-aos="fade-in">
    <div class="overlay"></div>

    <div class="container text-center hero-content" data-aos="zoom-out" data-aos-delay="100">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          @if($datos)
            <h2 class="hero-heading">{{ $datos->nombre }} {{ $datos->apellido }}</h2>
            <a href="{{ route('acerca') }}" class="btn-get-started">Sobre mí</a>
          @else
            <h2 class="hero-heading">¡Bienvenido!</h2>
            <p class="hero-sub">Aún no hay datos personales para mostrar.</p>
            <a href="{{ route('acerca') }}" class="btn-get-started">Sobre mí</a>
          @endif
        </div>
      </div>
    </div>
  </section>
</main>

<x-footer />

<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
  <i class="bi bi-arrow-up-short"></i>
</a>

<div id="preloader"></div>

<x-hero-adaptable />
