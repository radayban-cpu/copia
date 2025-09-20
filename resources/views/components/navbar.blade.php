<header id="header" class="header d-flex align-items-center light-background sticky-top">
  <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

    <!-- Logo -->
    <a href="{{ route('inicio') }}" class="logo d-flex align-items-center me-auto me-xl-0">
      <h1 class="sitename">Curriculum</h1>
    </a>

    <!-- Menú -->
    <nav id="navmenu" class="navmenu">
      <ul>
        <li><a href="{{ route('inicio') }}" class="{{ request()->routeIs('inicio') ? 'active' : '' }}">Inicio</a></li>
        <li><a href="{{ route('acerca-de') }}" class="{{ request()->routeIs('acerca-de') ? 'active' : '' }}">Acerca de</a></li>
        <li><a href="{{ route('resumen') }}" class="{{ request()->routeIs('resumen') ? 'active' : '' }}">Resumen</a></li>
        <li><a href="{{ route('servicio') }}" class="{{ request()->routeIs('servicio') ? 'active' : '' }}">Servicios</a></li>
        <li><a href="{{ route('portafolio') }}" class="{{ request()->routeIs('portafolio') ? 'active' : '' }}">Portafolio</a></li>
        <li><a href="{{ route('contacto') }}" class="{{ request()->routeIs('contacto') ? 'active' : '' }}">Contacto</a></li>
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

    <!-- Redes sociales -->
    <div class="header-social-links">
      <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
      <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
      <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
      <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
    </div>

  </div>
</header>
