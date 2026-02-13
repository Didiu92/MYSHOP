<!DOCTYPE html>
<html lang="es">
<head>
    @include('partials.head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-ebony text-silver">
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

    @stack('scripts')
</body>
</html>