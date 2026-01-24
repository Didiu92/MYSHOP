@php
    $productImages = $product->images->pluck('path')->values()->toArray();
@endphp

<div class="card overflow-hidden product-card {{ $class }} relative {{ $product->offer ? 'ring-2 ring-copper' : 'ring-2 ring-silver' }}"
     x-data="{ currentImage: 0, totalImages: {{ count($productImages) }} }">
    <!-- Badge de oferta destacado (esquina superior derecha) -->
    @if($product->offer)
        <div class="absolute top-0 right-0 bg-copper text-ebony px-4 py-2 rounded-bl-lg font-bold shadow-lg z-10">
            <span class="text-lg">
                -{{ $product->offer->discount_percentage }}%
            </span>
        </div>
    @endif

    <!-- Slot opcional para botón adicional en esquina superior izquierda (ej: eliminar de wishlist) -->
    @isset($topAction)
        <div class="absolute top-2 left-2 z-10">
            {{ $topAction }}
        </div>
    @endisset

    <div class="h-48 bg-ebony flex items-center justify-center overflow-hidden relative group">
        @if(count($productImages) > 0)
            <!-- Contenedor de imágenes -->
            <template x-if="currentImage === 0">
                <div class="absolute inset-0">
                    <img src="{{ asset('storage/' . $productImages[0]) }}"
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover">
                </div>
            </template>
            @foreach(array_slice($productImages, 1) as $index => $imagePath)
                <template x-if="currentImage === {{ $index + 1 }}">
                    <div class="absolute inset-0">
                        <img src="{{ asset('storage/' . $imagePath) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover">
                    </div>
                </template>
            @endforeach
            
            <!-- Botones de navegación (solo si hay múltiples imágenes) -->
            @if(count($productImages) > 1)
                <button @click="currentImage = (currentImage - 1 + totalImages) % totalImages"
                        style="left: 0.25rem;"
                        class="absolute top-1/2 -translate-y-1/2 bg-black bg-opacity-50 hover:bg-opacity-75 text-white p-1 rounded opacity-50 hover:opacity-100 transition z-10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button @click="currentImage = (currentImage + 1) % totalImages"
                        style="right: 0.25rem;"
                        class="absolute top-1/2 -translate-y-1/2 bg-black bg-opacity-50 hover:bg-opacity-75 text-white p-1 rounded opacity-50 hover:opacity-100 transition z-10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
                
                <!-- Indicadores -->
                <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-1 z-10">
                    @foreach($productImages as $index => $imagePath)
                        <button @click="currentImage = {{ $index }}"
                                :class="currentImage === {{ $index }} ? 'bg-gold' : 'bg-white/50'"
                                class="w-1.5 h-1.5 rounded-full transition"></button>
                    @endforeach
                </div>
            @endif
        @elseif(!empty($product->image))
            <img src="{{ asset('storage/' . $product->image) }}" 
                 alt="{{ $product->name }}" 
                 class="w-full h-full object-cover">
        @else
            <span class="text-4xl">📦</span>
        @endif
    </div>

    <div class="p-6">
        <h4 class="text-xl font-bold mb-2 text-gold">
            <a href="{{ route('products.show', $product->id) }}" class="hover:underline">
                {{ $product->name }}
            </a>
        </h4>
        <p class="text-silver mb-4">{{ Str::limit($product->description, 80) }}</p>

        <!-- Badge de oferta adicional (nombre de la oferta) -->
        @if($product->offer)
            <div class="mb-4">
                <a href="{{ route('offers.show', $product->offer->id) }}" class="inline-block bg-copper/20 text-copper text-xs px-3 py-1 rounded-full font-semibold border border-copper/40 hover:underline">
                    🏷️ {{ $product->offer->name }}
                </a>
            </div>
        @endif

        <!-- Precio -->
        <div class="mb-4">
            @if($product->offer)
                <div class="flex items-baseline gap-2">
                    <span class="text-sm text-silver/60 line-through">€{{ number_format($product->price, 2) }}</span>
                    <span class="text-2xl font-bold text-copper">€{{ number_format($product->final_price, 2) }}</span>
                </div>
            @else
                <span class="text-2xl font-bold text-gold">€{{ number_format($product->final_price, 2) }}</span>
            @endif
        </div>

        <!-- Acciones personalizables mediante slot -->
        @isset($actions)
            {{ $actions }}
        @else
            <!-- Acción por defecto: Ver Detalles -->
                <a href="{{ route('products.show', $product->id) }}" 
                    class="btn-primary block text-center">
                Ver Detalles
            </a>
        @endisset
    </div>
</div>