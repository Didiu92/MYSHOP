@extends('layouts.admin')

@section('content')
<div>
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gold mb-2">Bienvenido al Dashboard</h1>
        <p class="text-silver/70">{{ Auth::user()->name }}, gestiona tu tienda desde aquí.</p>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <!-- Productos -->
        <a href="{{ route('admin.products.index') }}" class="group">
            <div class="bg-graphite rounded-lg border border-gold/20 p-6 hover:border-gold/50 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-silver/50 text-sm font-medium mb-2">Productos</p>
                        <p class="text-4xl font-bold text-gold">{{ $stats['products'] }}</p>
                    </div>
                    <div class="bg-gold/10 rounded-full p-3 group-hover:bg-gold/20 transition">
                        <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4m0-10l8 4m-8-4v10"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-silver/70 text-sm mt-4">Gestionar productos →</p>
            </div>
        </a>

        <!-- Categorías -->
        <a href="{{ route('admin.categories.index') }}" class="group">
            <div class="bg-graphite rounded-lg border border-gold/20 p-6 hover:border-gold/50 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-silver/50 text-sm font-medium mb-2">Categorías</p>
                        <p class="text-4xl font-bold text-gold">{{ $stats['categories'] }}</p>
                    </div>
                    <div class="bg-gold/10 rounded-full p-3 group-hover:bg-gold/20 transition">
                        <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-silver/70 text-sm mt-4">Gestionar categorías →</p>
            </div>
        </a>

        <!-- Ofertas -->
        <a href="{{ route('admin.offers.index') }}" class="group">
            <div class="bg-graphite rounded-lg border border-gold/20 p-6 hover:border-gold/50 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-silver/50 text-sm font-medium mb-2">Ofertas</p>
                        <p class="text-4xl font-bold text-gold">{{ $stats['offers'] }}</p>
                    </div>
                    <div class="bg-gold/10 rounded-full p-3 group-hover:bg-gold/20 transition">
                        <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-silver/70 text-sm mt-4">Gestionar ofertas →</p>
            </div>
        </a>

        <!-- Usuarios - Solo para admin -->
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.users.index') }}" class="group">
                <div class="bg-graphite rounded-lg border border-gold/20 p-6 hover:border-gold/50 transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-silver/50 text-sm font-medium mb-2">Usuarios</p>
                            <p class="text-4xl font-bold text-gold">{{ $stats['users'] }}</p>
                        </div>
                        <div class="bg-gold/10 rounded-full p-3 group-hover:bg-gold/20 transition">
                            <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 8.048M7.002 9.5H3m4 .138A4.002 4.002 0 005.824 13M15 12.5h4.002m-4-.138A4.002 4.002 0 0018.176 13M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-silver/70 text-sm mt-4">Gestionar usuarios →</p>
                </div>
            </a>
        @endif
    </div>

    <!-- Acciones Rápidas -->
    <div class="bg-graphite rounded-lg border border-gold/20 p-8">
        <h2 class="text-2xl font-bold text-gold mb-6">Acciones Rápidas</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.products.create') }}" class="px-4 py-3 bg-gold hover:bg-gold/90 text-black font-semibold rounded-lg transition">
                    + Nuevo Producto
                </a>
                <a href="{{ route('admin.categories.create') }}" class="px-4 py-3 bg-copper hover:bg-copper/90 text-black font-semibold rounded-lg transition">
                    + Nueva Categoría
                </a>
                <a href="{{ route('admin.offers.create') }}" class="px-4 py-3 bg-silver hover:bg-silver/90 text-black font-semibold rounded-lg transition">
                    + Nueva Oferta
                </a>
                <a href="{{ route('admin.users.create') }}" class="px-4 py-3 bg-graphite border border-gold hover:bg-gold hover:text-black text-gold font-semibold rounded-lg transition">
                    + Nuevo Usuario
                </a>
            @else
                <div class="col-span-full px-4 py-3 bg-gold/10 border border-gold/20 rounded-lg text-silver/70">
                    <p class="text-sm">Tienes acceso de solo lectura. Contacta con un administrador para crear o modificar elementos.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
