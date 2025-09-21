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

  <section id="portfolio" class="portfolio section">

    <div class="container section-title" data-aos="fade-up">
      <h2>Portfolio</h2>
      <p>Aquí puedes ver algunos de mis proyectos más recientes. Cada uno representa un desafío único y una oportunidad para crecer.</p>
    </div>

    <div class="container">
      {{-- --- INICIO DE LA ACTUALIZACIÓN --- --}}
      <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

        {{-- Barra de Filtros de Categorías (Dinámica) --}}
        <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
          <li data-filter="*" class="filter-active">Todos</li>
          {{-- Este bucle crea un filtro por cada categoría que le enviamos desde el controlador --}}
          @if(isset($categorias))
            @foreach($categorias as $categoria)
              <li data-filter=".filter-{{ Str::slug($categoria->nombre) }}">{{ $categoria->nombre }}</li>
            @endforeach
          @endif
        </ul>{{-- Contenedor de Proyectos (Dinámico) --}}
        <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
          @if(isset($portafolios))
            @forelse ($portafolios as $item)
              {{-- La clase del div debe coincidir con el data-filter de su categoría --}}
              <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-{{ Str::slug($item->categoria->nombre) }}">
                <div class="portfolio-wrap">
                  <img src="{{ asset('storage/' . $item->url_imagen) }}" class="img-fluid" alt="{{ $item->titulo }}">
                  <div class="portfolio-info">
                    <h4>{{ $item->titulo }}</h4>
                    <p>{{ $item->categoria->nombre }}</p>
                    <div class="portfolio-links">
                      <a href="{{ asset('storage/' . $item->url_imagen) }}" data-gallery="portfolio-gallery-app" class="glightbox" title="{{ $item->titulo }}"><i class="bi bi-plus"></i></a>
                      <a href="#" title="More Details" class="details-link"><i class="bi bi-link"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            @empty
              <div class="col-12 text-center">
                <p>No hay proyectos cargados en este momento.</p>
              </div>
            @endforelse
          @endif
        </div></div>
      {{-- --- FIN DE LA ACTUALIZACIÓN --- --}}
    </div>
  </section></main>

<x-footer />