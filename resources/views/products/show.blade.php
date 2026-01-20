@extends('layouts.public')

@section('title', $product->name . ' - Mi Tienda')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Imagen del Producto -->
            <div class="card p-6">
                <div class="h-96 bg-graphite flex items-center justify-center">
                    <span class="text-8xl">📦</span>
                </div>
            </div>

            <!-- Información del Producto -->
            <div class="card p-6">
                <h1 class="text-3xl font-bold text-gold mb-4">{{ $product->name }}</h1>
                <p class="text-silver mb-6">{{ $product->description }}</p>
            
                <!-- Precio -->
                <div class="mb-6">
                    @if($product->offer)
                        <div class="flex items-baseline gap-3">
                            <span class="text-2xl text-silver/60 line-through">€{{ number_format($product->price, 2) }}</span>
                            <span class="text-4xl font-bold text-orange-600">€{{ number_format($product->final_price, 2) }}</span>
                        </div>
                        <p class="text-sm text-orange-600 mt-2">
                            ¡Ahorra €{{ number_format($product->price - $product->final_price, 2) }}!
                        </p>
                @else
                        <span class="text-4xl font-bold text-gold">€{{ number_format($product->price, 2) }}</span>
                @endif
            </div>
            
                <!-- Categoría -->
                @if($product->category)
                    <div class="mb-6">
                                <span class="text-sm text-silver/70">Categoría:</span>
                        <a href="{{ route('categories.show', $product->category->id) }}" 
                                    class="ml-2 badge">
                            {{ $product->category->name }}
                        </a>
                    </div>
                @endif
            
                <!-- Oferta -->
                @if($product->offer)
                    <div class="mb-6">
                        <span class="text-sm text-silver/70">Oferta activa:</span>
                        <div class="mt-2">
                            <span class="inline-block bg-orange-100 text-orange-800 text-sm px-3 py-1 rounded-full">
                                🏷️ {{ $product->offer->name }} (-{{ $product->offer->discount_percentage }}%)
                            </span>
        </div>
    </div>
@endif

<!-- Botones de Acción -->
<div class="flex items-center space-x-4">
    <form action="{{ route('cart.store') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <button type="submit" class="btn-primary">
            🛒 Añadir al Carrito
        </button>
    </form>

    {{-- Botón de Wishlist (solo para usuarios autenticados) --}}
    @auth
        <form action="{{ route('wishlist.store', $product->id) }}" method="POST">
            @csrf
                <button type="submit" class="border-2 border-red-500 text-red-500 px-6 py-3 rounded-lg hover:bg-red-500 hover:text-white transition">
                ❤️ Guardar en Favoritos
            </button>
        </form>
    @endauth

     <a href="{{ route('products.index') }}" 
         class="border border-gold/30 text-silver px-6 py-3 rounded-lg hover:bg-graphite transition">
        ← Volver a Productos
    </a>
</div>
            </div>
        </div>
    </div>
@endsection