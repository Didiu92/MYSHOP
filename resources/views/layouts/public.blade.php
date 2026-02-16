<!DOCTYPE html>
<html lang="es">
<head>
    @include('partials.head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- SVG Filters para accesibilidad (invisible pero disponible para filter property) -->
    <svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" style="position:absolute;width:0;height:0;overflow:hidden">
        <defs>
            <filter id="a11y-deuteranopia" color-interpolation-filters="sRGB">
                <feColorMatrix type="matrix" values="0.625 0.375 0 0 0 0.7 0.3 0 0 0 0 0.3 0.7 0 0 0 0 0 1 0" />
            </filter>
            <filter id="a11y-protanopia" color-interpolation-filters="sRGB">
                <feColorMatrix type="matrix" values="0.567 0.433 0 0 0 0.558 0.442 0 0 0 0 0.242 0.758 0 0 0 0 0 1 0" />
            </filter>
            <filter id="a11y-tritanopia" color-interpolation-filters="sRGB">
                <feColorMatrix type="matrix" values="0.95 0.05 0 0 0 0 0.433 0.567 0 0 0 0.475 0.525 0 0 0 0 0 1 0" />
            </filter>
        </defs>
    </svg>
</head>
<body class="bg-ebony text-silver">
    <div id="a11y-content">
        <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:bg-ebony focus:text-gold focus:px-4 focus:py-2 focus:rounded">
            Saltar al contenido principal
        </a>
        <!-- Header usando partial -->
        @include('partials.header')

        <!-- Notificaciones Flash -->
        @include('partials.flash-messages')
        
        <!-- Contenido principal -->
        <main id="main-content" class="min-h-screen">
            @yield('content')
        </main>
        
        <!-- Footer usando partial -->
        @include('partials.footer')
    </div>

    @include('partials.accessibility')

    @stack('scripts')
</body>
</html>