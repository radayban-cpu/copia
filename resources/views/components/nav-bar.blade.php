<nav id="navmenu" class="navmenu">
    <ul>
        <li><a href="{{ route('inicio') }}" class="{{ request()->routeIs('inicio') ? 'active' : '' }}">Inicio</a></li>
        <li><a href="{{ route('acerca') }}" class="{{ request()->routeIs('acerca-de') ? 'active' : '' }}">Acerca de</a></li>
        <li><a href="{{ route('resumen') }}" class="{{ request()->routeIs('resumen') ? 'active' : '' }}">Resumen</a></li>
        <li><a href="{{ route('servicios') }}" class="{{ request()->routeIs('servicio') ? 'active' : '' }}">Servicios</a></li>
        <li><a href="{{ route('portafolio') }}" class="{{ request()->routeIs('portafolio') ? 'active' : '' }}">Portafolio</a></li>
        <li><a href="{{ route('contactos') }}" class="{{ request()->routeIs('contacto') ? 'active' : '' }}">Contacto</a></li>
    </ul>
</nav>