{{-- resources/views/inicio.blade.php --}}

@php
  // Compatibilidad: usar $datos si existe, si no $datoPersonal
  $datos = $datos ?? ($datoPersonal ?? null);

  // Helper local para convertir rutas relativas de storage a URL completas
  $toUrl = function ($path, $default) {
      if (empty($path)) return $default;
      $s = (string)$path;
      if (str_starts_with($s, 'http://') || str_starts_with($s, 'https://') || str_starts_with($s, '/')) {
          return $s; // ya es URL absoluta o ruta absoluta
      }
      // ruta relativa (e.g. "imagenes/foto.jpg") -> usar storage público
      return asset('storage/'.$s);
  };

  // Normalizar imágenes (permitir string URL o path de storage)
  $imagenPerfil = $toUrl($imagenPerfil ?? null, asset('images/avatar.png'));
  $imagenMuro   = $toUrl($imagenMuro   ?? null, asset('assets/img/hero-bg.jpg'));

  // Ítems del "typed" (sin comas sobrantes)
  $typedItems = collect([
      $datos->carrera ?? null,
      $datos->frase   ?? null,
  ])->filter()->implode(', ');
@endphp

<x-layout />

<header id="header" class="header d-flex align-items-center light-background sticky-top">
  <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

    <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto me-xl-0">
      {{-- Logo dinámico (string URL o storage path normalizado) --}}
      @if(!empty($imagenPerfil))
        <img src="{{ $imagenPerfil }}" alt="Foto de perfil">
      @else
        <h1 class="sitename">Kelly</h1>
      @endif
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
    {{-- Imagen de muro normalizada --}}
    <img src="{{ $imagenMuro }}" alt="Imagen de portada" data-aos="fade-in">

    <div class="container text-center" data-aos="zoom-out" data-aos-delay="100">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          {{-- --- CONTENIDO DINÁMICO --- --}}
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
          {{-- --- FIN CONTENIDO DINÁMICO --- --}}
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
