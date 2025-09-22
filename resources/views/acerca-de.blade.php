<x-layout />

<header id="header" class="header d-flex align-items-center light-background sticky-top">
  <div class="container-fluid position-relative d-flex align-items-center justify-content-between">
    <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto me-xl-0">
      <h1 class="sitename">{{ optional($datoPersonal)->nombre ?? 'Inicio' }}</h1>
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

  {{-- ===================== SOBRE MÍ ===================== --}}
  <section id="about" class="about section">

    <div class="container section-title" data-aos="fade-up">
      <h2>Sobre Mí</h2>
      <p>{{ optional($datoPersonal)->descripcion ?? 'Aún no has añadido una descripción.' }}</p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row gy-4">

        {{-- Foto de perfil (del primer código) --}}
        <div class="col-lg-4 d-flex justify-content-center">
          <img src="{{ $fotoUrl }}" alt="Foto de perfil"
               class="img-fluid rounded-circle shadow" width="300" height="300">
        </div>

        {{-- Información personal --}}
        <div class="col-lg-8 content">
          <h2>{{ optional($datoPersonal)->carrera ?? 'Profesional' }}</h2>
          <p class="fst-italic py-3">
            {{ optional($datoPersonal)->frase ?? 'Aún no has añadido una frase.' }}
          </p>

          <div class="row">
            <div class="col-lg-6">
              <ul class="list-unstyled">
                <li class="mb-2">
                  <i class="bi bi-chevron-right"></i>
                  <strong>Nombre:</strong>
                  <span>{{ optional($datoPersonal)->nombre }} {{ optional($datoPersonal)->apellido }}</span>
                </li>
                <li class="mb-2">
                  <i class="bi bi-chevron-right"></i>
                  <strong>Fecha de Nacimiento:</strong>
                  <span>{{ optional($datoPersonal)->fecha_nacimiento ?? '—' }}</span>
                </li>
                <li class="mb-2">
                  <i class="bi bi-chevron-right"></i>
                  <strong>Ciudad:</strong>
                  <span>{{ optional($datoPersonal)->ciudad_domicilio ?? '—' }}</span>
                </li>
              </ul>
            </div>

            <div class="col-lg-6">
              <ul class="list-unstyled">
                <li class="mb-2">
                  <i class="bi bi-chevron-right"></i>
                  <strong>Edad:</strong>
                  <span>{{ optional($datoPersonal)->edad ?? '—' }}</span>
                </li>
                <li class="mb-2">
                  <i class="bi bi-chevron-right"></i>
                  <strong>Freelance:</strong> <span>Disponible</span>
                </li>
              </ul>
            </div>
          </div>

        </div>
      </div>
    </div>

  </section><!-- /About -->

{{-- ===================== HABILIDADES ===================== --}}
<section id="skills" class="skills section">

  <div class="container section-title" data-aos="fade-up">
    <h2>Habilidades</h2>
    <p>Algunas de mis competencias y su nivel actual.</p>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    @php
      $items = collect($habilidades ?? [])->map(function ($h) {
        return [
          'nombre' => $h->nombre,
          'nivel'  => max(0, min(100, (int) ($h->nivel ?? 0))),
          'tipo'   => optional($h->tipo)->nombre_habilidad,
        ];
      })->values();

      $half = (int) ceil($items->count() / 2);
      $col1 = $items->slice(0, $half)->values();
      $col2 = $items->slice($half)->values();

      $renderCol = function($col) {
        foreach ($col as $h) {
          $nivel = $h['nivel'];
          echo '<div class="mb-3">';
          echo '  <div class="d-flex justify-content-between align-items-center mb-1">';
          echo '    <span class="fw-semibold">'.e($h['nombre']).'</span>';
          echo '    <span class="text-muted">'.$nivel.'%</span>';
          echo '  </div>';
          echo '  <div class="progress" style="height:12px;border-radius:8px;background:#eee">';
          echo '    <div class="progress-bar" role="progressbar" aria-valuenow="'.$nivel.'" aria-valuemin="0" aria-valuemax="100" data-progress="'.$nivel.'" style="width:0%;height:12px;border-radius:8px;"></div>';
          echo '  </div>';
          echo '</div>';
        }
      };
    @endphp

    @if($items->isEmpty())
      <p class="text-center text-muted">Aún no cargaste habilidades desde el panel de administración.</p>
    @else
      <div class="row">
        <div class="col-lg-6">{!! $renderCol($col1) !!}</div>
        <div class="col-lg-6">{!! $renderCol($col2) !!}</div>
      </div>
    @endif
  </div>
</section>

{{-- Animación simple de barras de progreso (opcional) --}}
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const bars = document.querySelectorAll('.progress-bar[data-progress]');
    bars.forEach(bar => {
      const target = parseInt(bar.getAttribute('data-progress') || '0', 10);
      requestAnimationFrame(() => bar.style.width = target + '%');
    });
  });
</script>

{{-- ===================== TESTIMONIOS ===================== --}}
<section id="testimonials" class="testimonials section">
  <div class="container section-title" data-aos="fade-up">
    <h2>Testimonios</h2>
    <p>Lo que clientes y compañeros dicen de mí.</p>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    @php
      // Esperado: $testimonios sea una colección con ->mensaje, ->autor y opcional ->cargo
      $ts = collect($testimonios ?? []);
    @endphp

    @if($ts->isEmpty())
      <p class="text-center text-muted">Aún no hay testimonios cargados.</p>
    @else
      <div class="row gy-4">
        @foreach($ts as $t)
          <div class="col-md-6 col-lg-4">
            <div class="p-3 border rounded-3 h-100">
              <p class="mb-2">“{{ $t->mensaje ?? '' }}”</p>
              <div class="small text-muted">
                — {{ $t->autor ?? 'Anónimo' }}
                @if(!empty($t->cargo)) · {{ $t->cargo }} @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</section>

</main>

<x-footer />
