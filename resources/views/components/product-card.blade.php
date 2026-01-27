@php
    $productImages = $product->images->pluck('path')->values()->toArray();
    $isInWishlist = Auth::check() && Auth::user()->products()->where('product_id', $product->id)->exists();
    $isWishlistPage = request()->routeIs('wishlist.index');
@endphp

<div class="card overflow-hidden product-card {{ $class }} flex flex-col {{ $product->offer ? 'border-2 border-copper' : '' }}"
     x-data="{
        currentImage: 0,
        totalImages: {{ count($productImages) }},
        inWishlist: {{ $isInWishlist ? 'true' : 'false' }},
        productId: {{ $product->id }},
        isAuthenticated: {{ Auth::check() ? 'true' : 'false' }},
        addingToCart: false,
        isWishlistPage: {{ $isWishlistPage ? 'true' : 'false' }},
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
                    // Si estamos en la página de wishlist y se quita de favoritos, ocultar la tarjeta
                    if (this.isWishlistPage && !data.inWishlist) {
                        // Contar cuántas tarjetas de producto quedan antes de eliminar esta
                        const productCards = document.querySelectorAll('.product-card');
                        const remainingCards = productCards.length - 1;
                        
                        this.$root.style.transition = 'opacity 0.3s, transform 0.3s';
                        this.$root.style.opacity = '0';
                        this.$root.style.transform = 'scale(0.9)';
                        setTimeout(() => {
                            this.$root.remove();
                            // Si era el último producto, recargar la página para mostrar el mensaje de lista vacía
                            if (remainingCards === 0) {
                                window.location.reload();
                            }
                        }, 300);
                    }
                })
                .catch(e => console.error('Error:', e));
            } else {
                window.location.href = '{{ route('login') }}';
            }
        },
        addToCart() {
            if (!this.isAuthenticated) {
                window.location.href = '{{ route('login') }}';
                return;
            }
            
            this.addingToCart = true;
            
            fetch('{{ route('cart.store') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    product_id: this.productId,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                this.addingToCart = false;
                if (data.success) {
                    const notification = document.createElement('div');
                    notification.style.cssText = 'position: fixed; top: 20px; right: 20px; background: #FFD700; color: #1a1a1a; padding: 16px 24px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.3); z-index: 9999; display: flex; align-items: center; gap: 12px; font-weight: 600; animation: slideIn 0.3s ease-out;';
                    const checkmark = document.createElement('span');
                    checkmark.textContent = '✓';
                    checkmark.style.cssText = 'font-size: 24px; font-weight: bold;';
                    const text = document.createElement('span');
                    text.textContent = '¡Producto añadido al carrito!';
                    notification.appendChild(checkmark);
                    notification.appendChild(text);
                    
                    const style = document.createElement('style');
                    style.textContent = '@keyframes slideIn { from { transform: translateX(400px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }';
                    document.head.appendChild(style);
                    
                    document.body.appendChild(notification);
                    setTimeout(() => {
                        notification.style.animation = 'slideIn 0.3s ease-out reverse';
                        setTimeout(() => notification.remove(), 300);
                    }, 2500);
                } else {
                    alert(data.message || 'Error al añadir al carrito');
                }
            })
            .catch(e => {
                this.addingToCart = false;
                console.error('Error:', e);
                alert('Error al añadir al carrito');
            });
        }
     }">
    
    <!-- IMAGEN CUADRADA (contenedor dedicado) -->
        <div class="relative w-full aspect-square bg-ebony flex items-center justify-center overflow-hidden group flex-shrink-0 cursor-pointer"
            @click="window.location.href='{{ route('products.show', $product->id) }}?image=' + currentImage">
        <div class="block w-full h-full relative pointer-events-none">
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
        </div>

        <!-- Capa de overlays sobre la imagen -->
        <div class="absolute inset-0 z-20 pointer-events-none">
            @if($product->offer)
                <div class="absolute top-2 left-2 bg-copper text-ebony px-2 py-1 rounded font-bold shadow-lg text-xs">
                    -{{ $product->offer->discount_percentage }}%
                </div>
            @endif

            <button @click.stop.prevent="toggleWishlist()"
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
                    <button @click.stop.prevent="currentImage = {{ $index }}"
                            :class="currentImage === {{ $index }} ? 'bg-gold' : 'bg-white/50'"
                            class="w-1.5 h-1.5 rounded-full transition"></button>
                @endforeach
            </div>
        @endif
    </div>

    <!-- NOMBRE Y PRECIO (FUERA de la imagen, en su propio bloque) -->
    <div class="p-4 bg-ebony border-t border-silver/20">
        <div class="flex items-start justify-between gap-2 mb-3">
            <a href="{{ route('products.show', $product->id) }}" class="flex-1">
                <h4 class="text-xl font-bold text-gold line-clamp-2 hover:text-gold/80 transition">
                    {{ $product->name }}
                </h4>
            </a>
            <button @click.stop.prevent="addToCart()"
                    :disabled="addingToCart"
                    :class="addingToCart ? 'opacity-50 cursor-not-allowed' : 'hover:bg-copper hover:scale-110'"
                    class="flex-shrink-0 bg-gold text-ebony p-2 rounded-lg transition transform"
                    title="Añadir al carrito">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </button>
        </div>

        <!-- Precio -->
        <div>
            @if($product->offer)
                <div class="flex items-baseline gap-2">
                    <span class="text-xs text-silver/60 line-through">€{{ number_format($product->price, 2) }}</span>
                    <span class="text-lg font-bold text-copper">€{{ number_format($product->final_price, 2) }}</span>
                </div>
            @else
                <span class="text-lg font-bold text-gold">€{{ number_format($product->final_price, 2) }}</span>
            @endif
        </div>
    </div>
</div>
