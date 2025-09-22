{{-- resources/views/acerca.blade.php --}}

@php
    use Illuminate\Support\Facades\Storage;

    // Dato personal
    $datos = $datoPersonal ?? null;

    // El controller ya envía una URL lista en $imagenPerfil (o null)
    $urlImagenPerfil = !empty($imagenPerfil) ? $imagenPerfil : asset('assets/img/profile-img.jpg');

    // --- FORZAR FALLBACK SI LA RUTA ES /images|/assets|/img Y NO EXISTE EN PUBLIC ---
    $__pathFromUrl = parse_url($urlImagenPerfil ?? '', PHP_URL_PATH) ?: '';
    $__publicRel   = ltrim($__pathFromUrl, '/');
    $__isPublicThemePath = preg_match('#^(images|assets|img)/#i', $__publicRel) === 1;
    $__existsInPublic = $__isPublicThemePath ? file_exists(public_path($__publicRel)) : null;

    if ($__isPublicThemePath && !$__existsInPublic) {
        $urlImagenPerfil = asset('assets/img/profile-img.jpg');
        $__pathFromUrl = parse_url($urlImagenPerfil, PHP_URL_PATH) ?: '';
        $__publicRel   = ltrim($__pathFromUrl, '/');
        $__isPublicThemePath = preg_match('#^(images|assets|img)/#i', $__publicRel) === 1;
        $__existsInPublic = $__isPublicThemePath ? file_exists(public_path($__publicRel)) : null;
    }

    // DEBUG OPCIONAL (?debugimg=1)
    $__mostrarDebug = request()->query('debugimg') == '1';

    $__relStoragePath = null;
    if (str_starts_with($__pathFromUrl, '/storage/')) {
        $__relStoragePath = ltrim(substr($__pathFromUrl, strlen('/storage/')), '/');
    }
    $__existsOnDisk = !is_null($__relStoragePath)
        ? Storage::disk('public')->exists($__relStoragePath)
        : null;

    $__scheme = parse_url($urlImagenPerfil ?? '', PHP_URL_SCHEME) ?? 'relative';
    $__host   = parse_url($urlImagenPerfil ?? '', PHP_URL_HOST) ?? '—';

    // HABILIDADES (por si el controller no las mandó)
    $habilidades = collect($habilidades ?? []);
@endphp

<x-layout />

<header id="header" class="header d-flex align-items-center light-background sticky-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">
        <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto me-xl-0">
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

    {{-- ===================== SOBRE MÍ ===================== --}}
    <section id="about" class="about section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Sobre Mí</h2>
            <p>{{ optional($datos)->descripcion ?? 'Aún no has añadido una descripción.' }}</p>
        </div>

        {{-- PANEL DE DIAGNÓSTICO: visible solo con ?debugimg=1 --}}
        @if($__mostrarDebug)
            <div class="container mb-3">
                <div class="alert alert-info" role="alert" style="white-space:pre-wrap">
<strong>DEBUG imagen de perfil</strong>
URL: {{ $urlImagenPerfil }}
Scheme/Host: {{ $__scheme }} / {{ $__host }}
Path: {{ $__pathFromUrl ?: '—' }}

-- PUBLIC (theme) --
Es ruta pública (images/assets/img): {{ $__isPublicThemePath ? 'SÍ' : 'NO' }}
Existe en public_path():
    @if(is_null($__existsInPublic)) n/a
    @else {{ $__existsInPublic ? 'SÍ' : 'NO' }}
    @endif

-- STORAGE (disco public) --
Rel. en storage: {{ $__relStoragePath ?: '—' }}
Storage::disk('public')->exists():
    @if(is_null($__existsOnDisk)) n/a
    @else {{ $__existsOnDisk ? 'SÍ' : 'NO' }}
    @endif

<a href="{{ $urlImagenPerfil }}" target="_blank" rel="noopener">Abrir imagen en pestaña nueva</a>
                </div>
            </div>
        @endif

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4 justify-content-center">
                <div class="col-lg-4">
                    {{-- Foto de perfil dinámica con fallback --}}
                    <img src="{{ $urlImagenPerfil }}" class="img-fluid rounded" alt="Foto de perfil">

                    @if(request('debugimg') == '1')
                        <div class="mt-2 small text-muted" style="word-break: break-all;">
                            URL generada: <code>{{ $urlImagenPerfil ?? 'null' }}</code><br>
                            Public exists:
                            @if(is_null($__existsInPublic)) n/a
                            @else {{ $__existsInPublic ? 'SÍ' : 'NO' }}
                            @endif
                            <br>
                            Storage exists:
                            @if(is_null($__existsOnDisk)) n/a
                            @else {{ $__existsOnDisk ? 'SÍ' : 'NO' }}
                            @endif
                        </div>
                    @endif
                </div>

                <div class="col-lg-8 content">
                    <h2>{{ optional($datos)->carrera ?? 'Profesional' }}</h2>
                    <p class="fst-italic py-3">
                        {{ optional($datos)->frase ?? 'Aún no has añadido una frase.' }}
                    </p>

                    <div class="row">
                        <div class="col-lg-6">
                            <ul>
                                <li><i class="bi bi-chevron-right"></i> <strong>Nombre:</strong> <span>{{ optional($datos)->nombre }} {{ optional($datos)->apellido }}</span></li>
                                <li><i class="bi bi-chevron-right"></i> <strong>Fecha de Nacimiento:</strong> <span>{{ optional($datos)->fecha_nacimiento }}</span></li>
                                <li><i class="bi bi-chevron-right"></i> <strong>Ciudad:</strong> <span>{{ optional($datos)->ciudad_domicilio }}</span></li>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul>
                                <li><i class="bi bi-chevron-right"></i> <strong>Edad:</strong> <span>{{ optional($datos)->edad }}</span></li>
                                <li><i class="bi bi-chevron-right"></i> <strong>Freelance:</strong> <span>Disponible</span></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    {{-- ===================== HABILIDADES ===================== --}}
    <section id="skills" class="skills section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Habilidades</h2>
            <p>Algunas de mis competencias y su nivel actual.</p>
        </div>

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            @php
                // dividimos en dos columnas
                $items = $habilidades->map(function ($h) {
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
                    <div class="col-lg-6">
                        {!! $renderCol($col1) !!}
                    </div>
                    <div class="col-lg-6">
                        {!! $renderCol($col2) !!}
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- ===================== TESTIMONIOS (NUEVA SECCIÓN) ===================== --}}
    <section id="testimonials" class="testimonials section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Testimonios</h2>
            <p>Lo que clientes y compañeros dicen de mí.</p>
        </div>
    
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            @if(!isset($comentarios) || $comentarios->isEmpty())
                <p class="text-center text-muted">Aún no hay testimonios para mostrar.</p>
            @else
                <div class="swiper init-swiper">
                    {{-- Configuración del carrusel --}}
                    <script type="application/json" class="swiper-config">
                        {
                            "loop": true,
                            "speed": 600,
                            "autoplay": {
                                "delay": 5000
                            },
                            "slidesPerView": "auto",
                            "pagination": {
                                "el": ".swiper-pagination",
                                "type": "bullets",
                                "clickable": true
                            },
                            "breakpoints": {
                                "320": { "slidesPerView": 1, "spaceBetween": 40 },
                                "1200": { "slidesPerView": 3, "spaceBetween": 40 }
                            }
                        }
                    </script>
                    <div class="swiper-wrapper">
                        @foreach($comentarios as $comentario)
                            <div class="swiper-slide">
                                <div class="testimonial-item">
                                    <p>
                                        <i class="bi bi-quote quote-icon-left"></i>
                                        <span>{{ $comentario->contenido }}</span>
                                        <i class="bi bi-quote quote-icon-right"></i>
                                    </p>
                                    {{-- NOTA: La imagen es un placeholder. Más adelante podríamos hacerla dinámica. --}}
                                    <img src="{{ asset('assets/img/testimonials/testimonials-1.jpg') }}" class="testimonial-img" alt="">
                                    <h3>{{ optional($comentario->cliente)->nombre }}</h3>
                                    <h4>{{ optional($comentario->cliente)->empresa ?? 'Cliente' }}</h4>
                                </div>
                            </div>@endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            @endif
        </div>
    </section>

</main>

{{-- Script para animar las barras al entrar en pantalla --}}
<script>
    (function () {
        const bars = Array.from(document.querySelectorAll('.progress-bar[data-progress]'));
        if (!('IntersectionObserver' in window) || bars.length === 0) {
            // fallback: sin IO, setear al instante
            bars.forEach(b => b.style.width = (parseInt(b.dataset.progress || '0', 10)) + '%');
            return;
        }
        bars.forEach(b => { b.style.transition = 'width 1200ms ease'; });

        const io = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const pct = Math.max(0, Math.min(100, parseInt(el.dataset.progress || '0', 10)));
                    el.style.width = pct + '%';
                    obs.unobserve(el);
                }
            });
        }, { threshold: 0.25 });

        bars.forEach(b => io.observe(b));
    })();
</script>

<x-footer />

<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
</a>

<div id="preloader"></div>