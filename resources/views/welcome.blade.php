@extends('layouts.public')

@section('title', 'Joyería Aristocats - Joyas Exclusivas')

@push('styles')
    <style>
        .hero-gradient {
            background-image: url('{{ asset('images/fondo.webp') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }
        .hero-gradient::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
        }
        .hero-gradient > * {
            position: relative;
            z-index: 1;
        }
    </style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="hero-gradient text-white py-20">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl md:text-6xl font-extrabold leading-tight mb-6" style="text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8);">
                Bienvenidx a Joyería Aristocats
            </h2>
            <p class="text-xl md:text-2xl text-blue-100 mb-8 max-w-3xl mx-auto" style="text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.9);">
                Descubre nuestras exclusivas colecciones de joyas. 
                Cada pieza es un reflejo de elegancia y distinción.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('products.index', ['has_offer' => 'no']) }}"
                    class="border-2 border-gold text-gold font-bold py-4 px-8 rounded-full hover:bg-gold hover:text-ebony transition duration-300 ease-in-out transform hover:scale-105">
                    ✨ Novedades
                </a>
                <a href="{{ route('products.index', ['has_offer' => 'yes']) }}"
                    class="border-2 border-gold text-gold font-bold py-4 px-8 rounded-full hover:bg-gold hover:text-ebony transition duration-300 ease-in-out">
                    🏷️ Ofertas
                </a>
            </div>
        </div>
    </section>

    <!-- Productos Destacados - Carrusel -->
    <section class="py-16 bg-ebony">
        <div class="container mx-auto px-6">
            <h3 class="text-3xl font-bold mb-12 text-center text-gold">
                Joyas Destacadas
            </h3>
            
            @php $totalItems = $featuredProducts->count(); @endphp

            @if($totalItems > 0)
                <div 
                    x-data="{
                        currentIndex: 0,
                        totalItems: {{ $totalItems }},
                        visibleCount: 3,
                        positions() { return Math.max(this.totalItems - this.visibleCount + 1, 1); },
                        prev() { this.currentIndex = (this.currentIndex - 1 + this.positions()) % this.positions(); },
                        next() { this.currentIndex = (this.currentIndex + 1) % this.positions(); }
                    }"
                    class="relative"
                    x-init="console.log('Carrusel inicializado', totalItems, 'visibles', visibleCount)"
                >
                    <!-- Carrusel Container -->
                    <div class="overflow-hidden">
                        <div class="flex flex-nowrap transition-transform duration-500 ease-in-out"
                             :style="'transform: translateX(-' + (currentIndex * (100 / totalItems)) + '%)'">
                            @foreach($featuredProducts as $product)
                                <div style="flex: 0 0 33.3333%" class="box-border px-3">
                                    <x-product-card :product="$product" />
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Botones de navegación -->
                    <template x-if="positions() > 1">
                        <div>
                                <button type="button" @click="prev()"
                                    style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%);"
                                    class="bg-graphite border-2 border-gold hover:bg-gold hover:text-ebony text-gold px-4 py-3 rounded-lg transition z-10"
                                    aria-label="Anterior">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                                <button type="button" @click="next()"
                                    style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%);"
                                    class="bg-graphite border-2 border-gold hover:bg-gold hover:text-ebony text-gold px-4 py-3 rounded-lg transition z-10"
                                    aria-label="Siguiente">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </template>

                    <!-- Indicadores -->
                    <div class="flex justify-center gap-2 mt-8">
                        <template x-for="i in positions()" :key="i">
                            <button
                                type="button"
                                @click="currentIndex = i - 1"
                                :class="currentIndex === (i - 1) ? 'bg-gold' : 'bg-gray-400'"
                                class="w-3 h-3 rounded-full transition"
                                :aria-label="'Ir a la posicion ' + i"
                                :aria-current="currentIndex === (i - 1) ? 'true' : 'false'"
                            >
                            </button>
                        </template>
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500 dark:text-gray-400 text-lg">No hay productos destacados.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Categorías Destacadas -->
    <section class="py-16">
        <div class="container mx-auto px-6">
            <h3 class="text-3xl font-bold mb-12 text-center text-gold">
                Nuestras Categorías
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($featuredCategories as $category)
                    <x-category-card :category="$category" />
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 dark:text-gray-400 text-lg">No hay categorías disponibles.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection