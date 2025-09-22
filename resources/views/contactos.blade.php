<x-layout />

@php
  use App\Models\DatoPersonal;

  // Trae el perfil con sus contactos y tipos
  $dp = DatoPersonal::with('contactos.tipoContacto')->first();

  // Mapear contactos por nombre de tipo
  $byTipo = collect(optional($dp)->contactos ?? [])
      ->keyBy(fn($c) => optional($c->tipoContacto)->nombre);

  $correo   = optional($byTipo['correo'] ?? null)->valor;
  $telefono = optional($byTipo['telefono'] ?? null)->valor;
  $linkedin = optional($byTipo['linkedin'] ?? null)->valor;
  $mapsUrl  = optional($byTipo['google_maps'] ?? null)->valor;

  /**
   * Extrae [lat,lng] desde URL de Google Maps.
   */
  function gm_extract_latlng(?string $url): ?array {
      if (!$url) return null;
      // @LAT,LNG
      if (preg_match('~@(-?\d+\.\d+),\s*(-?\d+\.\d+)~', $url, $m)) {
          return [floatval($m[1]), floatval($m[2])];
      }
      // !2dLNG!3dLAT
      if (preg_match('~!2d(-?\d+\.\d+)!3d(-?\d+\.\d+)~', $url, $m)) {
          return [floatval($m[2]), floatval($m[1])];
      }
      // lat= & lng=
      if (preg_match('~[?&]lat=(-?\d+\.\d+)~', $url, $a) &&
          preg_match('~[?&]lng=(-?\d+\.\d+)~', $url, $b)) {
          return [floatval($a[1]), floatval($b[1])];
      }
      return null;
  }

  $coords = gm_extract_latlng($mapsUrl);
@endphp

{{-- Leaflet para mapa sin iframe --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script defer src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<style>
  #map { width: 100%; height: 270px; border-radius: 8px; }
</style>

<header id="header" class="header d-flex align-items-center light-background sticky-top">
  <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

    <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto me-xl-0">
      <h1 class="sitename">Kelly</h1>
    </a>

    <x-nav-bar />

    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>

    <div class="header-social-links">
      @if($linkedin)
        <a href="{{ $linkedin }}" class="linkedin" target="_blank" rel="noopener"><i class="bi bi-linkedin"></i></a>
      @endif
    </div>

  </div>
</header>

<main class="main">

  <!-- Contact Section -->
  <section id="contact" class="contact section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2>Contacto</h2>
      <p>
        @if($dp && $dp->frase)
          {{ $dp->frase }}
        @else
          Ponete en contacto para más información.
        @endif
      </p>
    </div>
    <!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

      <div class="row gy-4">

        <div class="col-lg-5">
          <div class="info-wrap">
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
              <i class="bi bi-geo-alt flex-shrink-0"></i>
              <div>
                <h3>Dirección</h3>
                <p>
                  @if($dp && $dp->ciudad_domicilio)
                    {{ $dp->ciudad_domicilio }}
                  @else
                    No especificada
                  @endif
                </p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-telephone flex-shrink-0"></i>
              <div>
                <h3>Teléfono</h3>
                <p>{{ $telefono ?? '—' }}</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-envelope flex-shrink-0"></i>
              <div>
                <h3>Correo</h3>
                <p>{{ $correo ?? '—' }}</p>
              </div>
            </div><!-- End Info Item -->

            @if($coords)
              <div id="map" data-aos="fade-up" data-aos-delay="450"></div>
              <script>
                document.addEventListener('DOMContentLoaded', function () {
                  const lat = {{ $coords[0] }};
                  const lng = {{ $coords[1] }};
                  const map = L.map('map').setView([lat, lng], 15);
                  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors'
                  }).addTo(map);
                  L.marker([lat, lng]).addTo(map);
                });
              </script>
            @elseif($mapsUrl)
              {{-- Fallback: si no se pueden extraer coords, mostramos link al mapa --}}
              <a href="{{ $mapsUrl }}" target="_blank" rel="noopener" class="d-inline-block mt-2">Ver en Google Maps</a>
            @endif
          </div>
        </div>

        <div class="col-lg-7">
          {{-- Mantengo el mismo form, traducido al español --}}
          <form action="{{ asset('forms/contact.php') }}" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
            <div class="row gy-4">

              <div class="col-md-6">
                <label for="name-field" class="pb-2">Tu nombre</label>
                <input type="text" name="name" id="name-field" class="form-control" required>
              </div>

              <div class="col-md-6">
                <label for="email-field" class="pb-2">Tu correo</label>
                <input type="email" class="form-control" name="email" id="email-field" required>
              </div>

              <div class="col-md-12">
                <label for="subject-field" class="pb-2">Asunto</label>
                <input type="text" class="form-control" name="subject" id="subject-field" required>
              </div>

              <div class="col-md-12">
                <label for="message-field" class="pb-2">Mensaje</label>
                <textarea class="form-control" name="message" rows="10" id="message-field" required></textarea>
              </div>

              <div class="col-md-12 text-center">
                <div class="loading">Enviando…</div>
                <div class="error-message"></div>
                <div class="sent-message">¡Tu mensaje fue enviado. Gracias!</div>
                <button type="submit">Enviar mensaje</button>
              </div>

            </div>
          </form>
        </div><!-- End Contact Form -->

      </div>

    </div>

  </section><!-- /Contact Section -->

</main>

<x-footer />

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
  <i class="bi bi-arrow-up-short"></i>
</a>

<!-- Preloader -->
<div id="preloader"></div>
