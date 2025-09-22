<header id="header" class="header d-flex align-items-center light-background sticky-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

        <a href="{{ route('inicio') }}" class="logo d-flex align-items-center me-auto me-xl-0">
            <h1 class="sitename">Curriculum</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ route('inicio') }}" class="{{ request()->routeIs('inicio') ? 'active' : '' }}">Inicio</a></li>
                <li><a href="{{ route('acerca-de') }}" class="{{ request()->routeIs('acerca-de') ? 'active' : '' }}">Acerca de</a></li>
                <li><a href="{{ route('resumen') }}" class="{{ request()->routeIs('resumen') ? 'active' : '' }}">Resumen</a></li>
                <li><a href="{{ route('servicios') }}" class="{{ request()->routeIs('servicio') ? 'active' : '' }}">Servicios</a></li>
                <li><a href="{{ route('portafolio') }}" class="{{ request()->routeIs('portafolio') ? 'active' : '' }}">Portafolio</a></li>
                <li><a href="{{ route('contacto') }}" class="{{ request()->routeIs('contacto') ? 'active' : '' }}">Contacto</a></li>

                @auth
                    <li class="ms-auto"><span>Hola, {{ Auth::user()->name }}</span></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); this.closest('form').submit();">
                                Cerrar Sesión
                            </a>
                        </form>
                    </li>
                @else
                    <li class="ms-auto"><a href="{{ route('login') }}">Iniciar Sesión</a></li>
                @endauth
            </ul>
        </nav>

    </div>
</header>