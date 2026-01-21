<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-ebony text-silver">
        <div class="min-h-screen">
            <!-- Navigation -->
            @include('layouts.navigation')

            <!-- Admin Sidebar + Content -->
            <div class="flex flex-1">
                <!-- Sidebar -->
                <aside class="w-64 bg-graphite border-r border-gold/20 min-h-screen">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gold mb-8">Dashboard</h2>
                        <nav class="space-y-2">
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-gold/20 text-gold' : 'text-silver hover:bg-graphite/50' }} transition">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Panel Principal
                            </a>

                            <div class="mt-8 pt-8 border-t border-gold/20">
                                <p class="text-xs font-semibold text-gold/50 uppercase tracking-wider mb-4">Gestión</p>
                                
                                <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.products.*') ? 'bg-gold/20 text-gold' : 'text-silver hover:bg-graphite/50' }} transition">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4m0-10l8 4m-8-4v10"></path>
                                    </svg>
                                    Productos
                                </a>

                                <a href="{{ route('admin.categories.index') }}" class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-gold/20 text-gold' : 'text-silver hover:bg-graphite/50' }} transition">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Categorías
                                </a>

                                <a href="{{ route('admin.offers.index') }}" class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.offers.*') ? 'bg-gold/20 text-gold' : 'text-silver hover:bg-graphite/50' }} transition">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Ofertas
                                </a>

                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-gold/20 text-gold' : 'text-silver hover:bg-graphite/50' }} transition">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 8.048M7.002 9.5H3m4 .138A4.002 4.002 0 005.824 13M15 12.5h4.002m-4-.138A4.002 4.002 0 0018.176 13M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Usuarios
                                    </a>
                                @endif
                            </div>
                        </nav>
                    </div>
                </aside>

                <!-- Main Content -->
                <main class="flex-1 p-8">
                    @yield('content')
                </main>
            </div>
        </div>
    </body>
</html>
