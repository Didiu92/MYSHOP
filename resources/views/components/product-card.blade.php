@php
    $productImages = $product->images->pluck('path')->values()->toArray();
    $isInWishlist = Auth::check() && Auth::user()->products()->where('product_id', $product->id)->exists();
@endphp

<div class="card overflow-hidden product-card {{ $class }} flex flex-col"
     x-data="{
        currentImage: 0,
        totalImages: {{ count($productImages) }},
        inWishlist: {{ $isInWishlist ? 'true' : 'false' }},
        productId: {{ $product->id }},
        isAuthenticated: {{ Auth::check() ? 'true' : 'false' }},
        toggleWishlist() {
            if (this.isAuthenticated) {
                fetch('{{ route('wishlist.store', ':id') }}'.replace(':id', this.productId), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    this.inWishlist = data.inWishlist;
                })
                .catch(e => console.error('Error:', e));
            } else {
                window.location.href = '{{ route('login') }}';
            }
        }
     }">
    
    <!-- IMAGEN CUADRADA (contenedor dedicado) -->
    <div class="relative w-full aspect-square bg-ebony flex items-center justify-center overflow-hidden group flex-shrink-0">
        <a href="{{ route('products.show', $product->id) }}" class="block w-full h-full relative pointer-events-none">
            @if(count($productImages) > 0)
                <!-- Contenedor de imágenes -->
                <template x-if="currentImage === 0">
                    <div class="absolute inset-0 z-0 pointer-events-auto">
                        <img src="{{ asset('storage/' . $productImages[0]) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </div>
                </template>
                @foreach(array_slice($productImages, 1) as $index => $imagePath)
                    <template x-if="currentImage === {{ $index + 1 }}">
                        <div class="absolute inset-0 z-0 pointer-events-auto">
                            <img src="{{ asset('storage/' . $imagePath) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        </div>
                    </template>
                @endforeach
            @elseif(!empty($product->image))
                <img src="{{ asset('storage/' . $product->image) }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
            @else
                <span class="text-6xl">📦</span>
            @endif
        </a>

        <!-- Capa de overlays sobre la imagen -->
        <div class="absolute inset-0 z-20 pointer-events-none">
            @if($product->offer)
                <div class="absolute top-2 left-2 bg-copper text-ebony px-2 py-1 rounded font-bold shadow-lg text-xs">
                    -{{ $product->offer->discount_percentage }}%
                </div>
            @endif

            <button @click.prevent="toggleWishlist()"
            class="absolute top-2 right-2 transition transform hover:scale-110 cursor-pointer p-1 pointer-events-auto">
                <svg :fill="inWishlist ? '#ef4444' : 'none'"
                     stroke="#ef4444"
                     stroke-width="2"
                     class="w-6 h-6"
                     viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
            </button>
        </div>

        <!-- Navegación de imágenes (solo si hay múltiples) -->
        @if(count($productImages) > 1)
            <button @click="currentImage = (currentImage - 1 + totalImages) % totalImages; $event.stopPropagation();"
                    class="absolute left-2 top-1/2 -translate-y-1/2 bg-graphite/80 hover:bg-gold text-gold hover:text-ebony p-1 rounded transition z-50 opacity-0 group-hover:opacity-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button @click="currentImage = (currentImage + 1) % totalImages; $event.stopPropagation();"
                    class="absolute right-2 top-1/2 -translate-y-1/2 bg-graphite/80 hover:bg-gold text-gold hover:text-ebony p-1 rounded transition z-50 opacity-0 group-hover:opacity-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
            
            <!-- Indicadores de imagen -->
            <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-1 z-30 opacity-0 group-hover:opacity-100 transition">
                @foreach($productImages as $index => $imagePath)
                    <button @click.prevent="currentImage = {{ $index }}"
                            :class="currentImage === {{ $index }} ? 'bg-gold' : 'bg-white/50'"
                            class="w-1.5 h-1.5 rounded-full transition"></button>
                @endforeach
            </div>
        @endif
    </div>

    <!-- NOMBRE Y PRECIO (FUERA de la imagen, en su propio bloque) -->
    <div class="p-4 bg-ebony border-t border-silver/20">
        <a href="{{ route('products.show', $product->id) }}" class="block">
            <h4 class="text-lg font-bold text-gold mb-3 line-clamp-2 hover:text-gold/80 transition">
                {{ $product->name }}
            </h4>
        </a>

        <!-- Precio -->
        <div>
            @if($product->offer)
                <div class="flex items-baseline gap-2">
                    <span class="text-xs text-silver/60 line-through">€{{ number_format($product->price, 2) }}</span>
                    <span class="text-xl font-bold text-copper">€{{ number_format($product->final_price, 2) }}</span>
                </div>
            @else
                <span class="text-xl font-bold text-gold">€{{ number_format($product->final_price, 2) }}</span>
            @endif
        </div>
    </div>
</div>
