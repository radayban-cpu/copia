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
  <section id="resume" class="resume section">
    <div class="container section-title" data-aos="fade-up">
      <h2>Resumen</h2>
    </div>

    <div class="container">
      @php
        use Illuminate\Support\Str;

        $lista = collect($experiencias ?? []);
        $fmt = function($date, $format='Y') {
          try { return $date ? \Carbon\Carbon::parse($date)->format($format) : null; }
          catch (\Exception $e) { return $date; }
        };

        // Separar por tipo (Educación vs. resto) según el nombre del tipo
        $educ = $lista->filter(fn($e) => Str::contains(Str::lower(optional(optional($e)->tipo)->nombre), 'educ'));
        $prof = $lista->filter(fn($e) => !Str::contains(Str::lower(optional(optional($e)->tipo)->nombre), 'educ'));
      @endphp

      <div class="row">
        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
          <h3 class="resume-title">Educación</h3>

          @forelse($educ as $exp)
            <div class="resume-item">
              <h4>{{ $exp->titulo }}</h4>
              @php
                $ini = $fmt($exp->fecha_inicio, 'Y');
                $fin = $fmt($exp->fecha_fin, 'Y') ?? 'Actual';
              @endphp
              @if($ini || $fin)
                <h5>{{ $ini }}{{ $ini && $fin ? ' - ' : '' }}{{ $fin }}</h5>
              @endif
              @if(!empty($exp->institucion))
                <p><em>{{ $exp->institucion }}</em></p>
              @endif
              @if(!empty($exp->descripcion))
                <p>{!! nl2br(e($exp->descripcion)) !!}</p>
              @endif
            </div>
          @empty
            <p class="text-muted">No hay experiencias educativas cargadas.</p>
          @endforelse
        </div>

        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200)">
          <h3 class="resume-title">Experiencia Profesional</h3>

          @forelse($prof as $exp)
            <div class="resume-item">
              <h4>{{ $exp->titulo }}</h4>
              @php
                $ini = $fmt($exp->fecha_inicio, 'Y');
                $fin = $fmt($exp->fecha_fin, 'Y') ?? 'Actual';
              @endphp
              @if($ini || $fin)
                <h5>{{ $ini }}{{ $ini && $fin ? ' - ' : '' }}{{ $fin }}</h5>
              @endif
              @if(!empty($exp->empresa))
                <p><em>{{ $exp->empresa }}</em></p>
              @endif

              @php
                $items = array_filter(preg_split("/\r\n|\n|\r/", $exp->descripcion ?? ''));
              @endphp
              @if(count($items) > 1)
                <ul>
                  @foreach($items as $line)
                    <li>{{ $line }}</li>
                  @endforeach
                </ul>
              @elseif(!empty($exp->descripcion))
                <p>{!! nl2br(e($exp->descripcion)) !!}</p>
              @endif
            </div>
          @empty
            <p class="text-muted">No hay experiencias profesionales cargadas.</p>
          @endforelse
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
