<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Panel de Administración - Mi Portafolio</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }
        .sidebar {
            width: 280px;
            min-height: 100vh;
        }
        .main-content {
            flex-grow: 1;
            padding: 2rem;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar d-flex flex-column flex-shrink-0 p-3 text-white bg-dark">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <i class="bi bi-person-circle me-2 fs-4"></i>
                <span class="fs-4">Admin Panel</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ route('admin.datos-personales.index') }}" class="nav-link text-white {{ request()->routeIs('admin.datos-personales.*') ? 'active' : '' }}">
                        <i class="bi bi-person-vcard me-2"></i>
                        Datos Personales
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.imagenes.index') }}" class="nav-link text-white {{ request()->routeIs('admin.imagenes.*') ? 'active' : '' }}">
                        <i class="bi bi-images me-2"></i>
                        Imágenes
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.portafolios.index') }}" class="nav-link text-white {{ request()->routeIs('admin.portafolios.*') ? 'active' : '' }}">
                        <i class="bi bi-briefcase me-2"></i>
                        Portafolios
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.servicios.index') }}" class="nav-link text-white {{ request()->routeIs('admin.servicios.*') ? 'active' : '' }}">
                        <i class="bi bi-gear-wide-connected me-2"></i>
                        Servicios
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.experiencias.index') }}" class="nav-link text-white {{ request()->routeIs('admin.experiencias.*') ? 'active' : '' }}">
                        <i class="bi bi-journal-text me-2"></i>
                        Experiencias
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.habilidades.index') }}" class="nav-link text-white {{ request()->routeIs('admin.habilidades.*') ? 'active' : '' }}">
                        <i class="bi bi-star me-2"></i>
                        Habilidades
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.clientes.index') }}" class="nav-link text-white {{ request()->routeIs('admin.clientes.*') || request()->routeIs('admin.comentarios.*') ? 'active' : '' }}">
                        <i class="bi bi-chat-quote-fill me-2"></i>
                        Testimonios
                    </a>
                </li>

                {{-- NUEVO: Contactos --}}
       <li>
                    <a href="{{ route('admin.contactos.index') }}" class="nav-link text-white {{ request()->routeIs('admin.contactos.*') ? 'active' : '' }}">
                        <i class="bi bi-telephone-fill me-2"></i>
                        Contactos
                    </a>
                </li>

                <li>
                    <a href="{{ route('inicio') }}" class="nav-link text-white">
                        <i class="bi bi-box-arrow-left me-2"></i>
                        Volver al Sitio
                    </a>
                </li>
            </ul>
            <hr>
        </div>

        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>