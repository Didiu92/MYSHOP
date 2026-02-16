<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/favicon/favicon.png') }}">
        <style>
            link[rel="icon"] {
                border-radius: 50%;
            }
        </style>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
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
    <body class="font-sans antialiased">
        <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:bg-ebony focus:text-gold focus:px-4 focus:py-2 focus:rounded">
            Saltar al contenido principal
        </a>
        <div id="a11y-content" {{ $attributes->merge(['class' => 'min-h-screen bg-ebony']) }}>
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-graphite shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Notificaciones Flash -->
            @include('partials.flash-messages')

            <!-- Page Content -->
            <main id="main-content">
                {{ $slot }}
            </main>
        </div>

        @include('partials.accessibility')
    </body>
</html>