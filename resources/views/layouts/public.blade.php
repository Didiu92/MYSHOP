<!DOCTYPE html>
<html lang="es">
<head>
    @include('partials.head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-ebony text-silver">
    <div id="a11y-wrapper" class="min-h-screen w-full">
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

    <!-- SVG Filters para accesibilidad -->
    <div id="filter_id_a11y_color" style="height: 0; padding: 0; margin: 0; line-height: 0;">
        <svg id="colorblind-filters" style="display: none">
            <defs>
                <filter id="a11y-deuteranopia" color-interpolation-filters="linearRGB">
                    <feColorMatrix type="matrix" values="0.29031,0.70969,-0.00000,0,0 0.29031,0.70969,-0.00000,0,0 -0.02197,0.02197,1.00000,0,0 0,0,0,1,0" in="SourceGraphic"></feColorMatrix>
                </filter>
                <filter id="a11y-protanopia" color-interpolation-filters="linearRGB">
                    <feColorMatrix type="matrix" values="0.567,0.433,0,0,0 0.558,0.442,0,0,0 0,0.242,0.758,0,0 0,0,0,1,0" in="SourceGraphic"></feColorMatrix>
                </filter>
                <filter id="a11y-tritanopia" color-interpolation-filters="linearRGB">
                    <feColorMatrix type="matrix" values="0.95,0.05,0,0,0 0,0.433,0.567,0,0 0,0.475,0.525,0,0 0,0,0,1,0" in="SourceGraphic"></feColorMatrix>
                </filter>
            </defs>
        </svg>
    </div>

    @stack('scripts')
</body>
</html>