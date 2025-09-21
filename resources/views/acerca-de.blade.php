<x-layout />

<header id="header" class="header d-flex align-items-center light-background sticky-top">
  <div class="container-fluid position-relative d-flex align-items-center justify-content-between">
    <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto me-xl-0">
      <h1 class="sitename">Kelly</h1>
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

  <section id="about" class="about section">

    <div class="container section-title" data-aos="fade-up">
      {{-- --- INICIO DE LA ACTUALIZACIÓN --- --}}
      <h2>Sobre Mí</h2>
      <p>{{ $datos->descripcion ?? 'Aún no has añadido una descripción.' }}</p>
      {{-- --- FIN DE LA ACTUALIZACIÓN --- --}}
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row gy-4 justify-content-center">
        <div class="col-lg-4">
          <img src="{{ asset('assets/img/profile-img.jpg') }}" class="img-fluid" alt="">
        </div>
        <div class="col-lg-8 content">
          {{-- --- INICIO DE LA ACTUALIZACIÓN --- --}}
          <h2>{{ $datos->carrera ?? 'Profesional' }}</h2>
          <p class="fst-italic py-3">
            {{ $datos->frase ?? 'Aún no has añadido una frase.' }}
          </p>
          <div class="row">
            <div class="col-lg-6">
              <ul>
                <li><i class="bi bi-chevron-right"></i> <strong>Nombre:</strong> <span>{{ $datos->nombre ?? '' }} {{ $datos->apellido ?? '' }}</span></li>
                <li><i class="bi bi-chevron-right"></i> <strong>Fecha de Nacimiento:</strong> <span>{{ $datos->fecha_nacimiento ?? '' }}</span></li>
                <li><i class="bi bi-chevron-right"></i> <strong>Ciudad:</strong> <span>{{ $datos->ciudad_domicilio ?? '' }}</span></li>
              </ul>
            </div>
            <div class="col-lg-6">
              <ul>
                <li><i class="bi bi-chevron-right"></i> <strong>Edad:</strong> <span>{{ $datos->edad ?? '' }}</span></li>
                {{-- Puedes añadir más campos como email o teléfono si los agregas a la base de datos --}}
                <li><i class="bi bi-chevron-right"></i> <strong>Freelance:</strong> <span>Disponible</span></li>
              </ul>
            </div>
          </div>
          {{-- --- FIN DE LA ACTUALIZACIÓN --- --}}
        </div>
      </div>
    </div>
  </section>
  {{-- Las demás secciones como Skills, Stats, etc., se quedan igual por ahora --}}

</main>

<x-footer />

<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
  <i class="bi bi-arrow-up-short"></i>
</a>

<div id="preloader"></div>