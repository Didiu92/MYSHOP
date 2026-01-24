@extends('layouts.public')

@section('title', $product->name . ' - Mi Tienda')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Carrusel de Imágenes -->
            <div class="card p-6" x-data="{ 
                currentImage: 0, 
                images: {{ json_encode($product->images->pluck('path')->values()->toArray()) }}
            }">
                <div class="relative">
                    <!-- Imagen principal -->
                    <div class="h-96 bg-graphite flex items-center justify-center rounded-lg overflow-hidden relative">
                        @if ($product->images->count() > 0)
                            <template x-for="(image, index) in images" :key="index">
                                <div x-show="currentImage === index"
                                     x-transition
                                     class="absolute inset-0">
                                    <img :src="'{{ asset('storage') }}/' + image"
                                         :alt="'Imagen ' + (index + 1) + ' de {{ $product->name }}'"
                                         class="w-full h-full object-cover">
                                </div>
                            </template>
                        @else
                            <span class="text-8xl">📦</span>
                        @endif

                        <!-- Botones de navegación (solo si hay múltiples imágenes) -->
                        @if ($product->images->count() > 1)
                            <!-- Botón anterior -->
                            <button @click="currentImage = (currentImage - 1 + images.length) % images.length"
                                    style="left: 1rem;" 
                                    class="absolute top-1/2 -translate-y-1/2 z-20 bg-black bg-opacity-50 hover:bg-opacity-75 text-white px-3 py-2 rounded-lg transition">
                                ◀
                            </button>

                            <!-- Botón siguiente -->
                            <button @click="currentImage = (currentImage + 1) % images.length"
                                    style="right: 1rem;"
                                    class="absolute top-1/2 -translate-y-1/2 z-20 bg-black bg-opacity-50 hover:bg-opacity-75 text-white px-3 py-2 rounded-lg transition">
                                ▶
                            </button>

                            <!-- Indicadores de posición -->
                            <div class="absolute bottom-3 left-1/2 -translate-x-1/2 z-10 flex gap-2">
                                <template x-for="(image, index) in images" :key="index">
                                    <button @click="currentImage = index"
                                            :class="currentImage === index ? 'bg-gold' : 'bg-gray-400'"
                                            class="w-2 h-2 rounded-full transition">
                                    </button>
                                </template>
                            </div>

                            <!-- Contador de imágenes -->
                            <div class="absolute top-3 right-3 z-10 bg-black bg-opacity-70 text-gold px-2 py-1 rounded text-sm">
                                <span x-text="currentImage + 1"></span> / <span x-text="images.length"></span>
                            </div>
                        @endif
                    </div>

                    <!-- Miniaturas -->
                    @if ($product->images->count() > 1)
                        <div class="mt-4 flex gap-2 overflow-x-auto">
                            @foreach ($product->images as $image)
                                <button @click="currentImage = {{ $loop->index }}"
                                        :class="currentImage === {{ $loop->index }} ? 'ring-2 ring-gold' : 'ring-1 ring-gray-400'"
                                        class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden transition">
                                    <img src="{{ asset('storage/' . $image->path) }}"
                                         alt="Miniatura {{ $loop->index + 1 }}"
                                         class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Información del Producto -->
            <div class="card p-6">
                <div class="flex items-start justify-between gap-6 mb-8">
                    <h1 class="text-3xl font-bold text-gold">{{ $product->name }}</h1>
                    
                    {{-- Botones de Admin: Editar y Eliminar (esquina superior derecha) --}}
                    @auth
                        @if(auth()->user()->isAdmin())
                            <div class="flex flex-col gap-2 whitespace-nowrap">
                                <a href="{{ route('admin.products.edit', $product->id) }}" 
                                   class="bg-ebony text-silver border-2 border-silver px-4 py-2 rounded-lg hover:bg-silver hover:text-ebony transition text-sm font-semibold">
                                    ✏️ Editar
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-graphite text-red-500 border-2 border-red-500 px-4 py-2 rounded-lg hover:bg-red-500 hover:text-white transition text-sm font-semibold w-full">
                                        🗑️ Eliminar
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
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