<x-layout />

<header id="header" class="header d-flex align-items-center light-background sticky-top">
  <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

    <a href="/" class="logo d-flex align-items-center me-auto me-xl-0">
      {{-- Usar el logo dinámico si existe --}}
      @if($imagenPerfil)
      <img src="{{ asset('storage/' . $imagenPerfil->ruta) }}" alt="Foto de perfil">
      @else
      <h1 class="sitename">Kelly</h1>
      @endif
    </a>

    {{-- Navbar (usar kebab-case) --}}
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
    @if($imagenMuro)
    <img src="{{ asset('storage/' . $imagenMuro->ruta) }}" alt="Imagen de muro" data-aos="fade-in">
    @else
    {{-- Si no hay imagen de muro, puedes usar una por defecto --}}
    <img src="{{ asset('assets/img/hero-bg.jpg') }}" alt="Imagen de muro por defecto" data-aos="fade-in">
    @endif
    <div class="container text-center" data-aos="zoom-out" data-aos-delay="100">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          @if($datoPersonal)
          <h2>{{ $datoPersonal->titulo }}</h2>
          <p>Soy <span class="typed" data-typed-items="{{ $datoPersonal->subtitulo }}"></span></p>
          <a href="/acerca-de" class="btn-get-started">Sobre mí</a>
          @else
          <h2>¡Bienvenido!</h2>
          <p>Aún no hay datos personales para mostrar. Por favor, añádelos en el panel de administración.</p>
          <a href="/acerca-de" class="btn-get-started">Sobre mí</a>
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

<div id="preloader"></div>p