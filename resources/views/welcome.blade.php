@extends('layouts.public')

@section('title', 'Joyería Aristocats - Joyas Exclusivas')

@push('styles')
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="hero-gradient text-white py-20">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl md:text-6xl font-extrabold leading-tight mb-6">
                Bienvenidx a Joyería Aristocats
            </h2>
            <p class="text-xl md:text-2xl text-blue-100 mb-8 max-w-3xl mx-auto">
                Descubre nuestras exclusivas colecciones de joyas. 
                Cada pieza es un reflejo de elegancia y distinción.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('products.index') }}"
                    class="bg-white text-primary-600 font-bold py-4 px-8 rounded-full hover:bg-gray-100 transition duration-300 ease-in-out transform hover:scale-105">
                    Ver Colecciones
                </a>
                <a href="{{ route('products.on-sale') }}"
                    class="border-2 border-white text-white font-bold py-4 px-8 rounded-full hover:bg-white hover:text-primary-600 transition duration-300 ease-in-out">
                    ✨ Piezas Exclusivas
                </a>
            </div>
        </div>
    </section>

    <!-- Categorías Destacadas -->
    <section class="py-16">
        <div class="container mx-auto px-6">
            <h3 class="text-3xl font-bold mb-12 text-center text-gray-900 dark:text-white">
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

    <!-- Productos Destacados -->
    <section class="py-16 bg-gray-100 dark:bg-gray-800">
        <div class="container mx-auto px-6">
            <h3 class="text-3xl font-bold mb-12 text-center text-gray-900 dark:text-white">
                Joyas Destacadas
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 dark:text-gray-400 text-lg">No hay productos destacados.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection