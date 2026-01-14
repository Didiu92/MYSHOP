<div class="bg-white rounded-lg shadow-lg overflow-hidden product-card {{ $class }} relative {{ $product->offer ? 'ring-2 ring-orange-400' : '' }}">
    <!-- Badge de oferta destacado (esquina superior derecha) -->
    @if($product->offer)
        <div class="absolute top-0 right-0 bg-gradient-to-r from-orange-500 to-red-500 text-white px-4 py-2 rounded-bl-lg font-bold shadow-lg z-10">
            <span class="text-lg">
                -{{ $product->offer->discount_percentage }}%
            </span>
    </div>
    @endif
    
    <div class="h-48 bg-gray-200 flex items-center justify-center {{ $product->offer ? 'bg-gradient-to-br from-orange-50 to-red-50' : '' }}">
        <span class="text-4xl">📦</span>
</div>
    <div class="p-6">
        <h4 class="text-xl font-bold mb-2 text-gray-900">{{ $product->name }}</h4>
        <p class="text-gray-600 mb-4">{{ $product->description }}</p>
        
        <!-- Badge de oferta adicional (nombre de la oferta) -->
        @if($product->offer)
            <div class="mb-4">
                <span class="inline-block bg-orange-100 text-orange-800 text-xs px-3 py-1 rounded-full font-semibold">
                    🏷️ {{ $product->offer->name }}
                </span>
            </div>
        @endif
        
        <div class="flex items-center justify-between flex-wrap gap-2">
            <div class="flex flex-col">
                @if($product->offer)
                    <span class="text-sm text-gray-400 line-through">€{{ number_format($product->price, 2) }}</span>
                    <span class="text-2xl font-bold text-orange-600">€{{ number_format($product->final_price, 2) }}</span>
                @else
                    <span class="text-2xl font-bold text-primary-600">€{{ number_format($product->price, 2) }}</span>
                @endif
            </div>
            <a href="{{ route('products.show', $product->id) }}" 
               class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition">
                Ver Detalles
            </a>
        </div>
    </div>
</div>