<div class="card overflow-hidden product-card {{ $class }} relative {{ $product->offer ? 'ring-2 ring-copper' : 'ring-2 ring-silver' }}">
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

    <div class="h-48 bg-ebony flex items-center justify-center overflow-hidden">
        @if(!empty($product->image))
            <img src="{{ asset('storage/' . $product->image) }}" 
                 alt="{{ $product->name }}" 
                 class="w-full h-full object-cover">
        @else
            <span class="text-4xl">📦</span>
        @endif
    </div>

    <div class="p-6">
        <h4 class="text-xl font-bold mb-2 text-gold">{{ $product->name }}</h4>
        <p class="text-silver mb-4">{{ Str::limit($product->description, 80) }}</p>

        <!-- Badge de oferta adicional (nombre de la oferta) -->
        @if($product->offer)
            <div class="mb-4">
                <span class="inline-block bg-copper/20 text-copper text-xs px-3 py-1 rounded-full font-semibold border border-copper/40">
                    🏷️ {{ $product->offer->name }}
                </span>
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