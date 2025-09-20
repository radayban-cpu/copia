{{-- resources/views/inicio.blade.php --}}
<x-layout />

<header id="header" class="header d-flex align-items-center light-background sticky-top">
  <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

    <a href="/" class="logo d-flex align-items-center me-auto me-xl-0">
      {{-- <img src="{{ asset('assets/img/logo.png') }}" alt=""> --}}
      <h1 class="sitename">Kelly</h1>
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

  <!-- Hero Section -->
  <section id="hero" class="hero section">
    <img src="{{ asset('assets/img/hero-bg.jpg') }}" alt="" data-aos="fade-in">
    <div class="container text-center" data-aos="zoom-out" data-aos-delay="100">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <h2>Kelly Adams</h2>
          <p>Soy ilustradora profesional con base en San Francisco</p>
          <a href="/acerca-de" class="btn-get-started">Sobre mí</a>
        </div>
      </div>
    </div>
  </section>
  <!-- /Hero Section -->

</main>

<x-footer />

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
  <i class="bi bi-arrow-up-short"></i>
</a>

<!-- Preloader -->
<div id="preloader"></div>
