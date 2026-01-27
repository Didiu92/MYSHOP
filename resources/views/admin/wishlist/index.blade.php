<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gold leading-tight">
            {{ __('Mi Lista de Deseos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card overflow-hidden sm:rounded-lg">
                <div class="p-6">
                    @if($wishlistProducts->isEmpty())
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">💔</div>
                            <h3 class="text-2xl font-bold text-gold mb-2">Tu lista de deseos está vacía</h3>
                            <p class="text-silver mb-6">Explora nuestros productos y guarda tus favoritos</p>
                            <a href="{{ route('products.index') }}" class="inline-block btn-primary">
                                Explorar Productos
                            </a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($wishlistProducts as $product)
                                <x-product-card :product="$product" class="">
                                    {{-- Slot para botón de eliminar en esquina superior izquierda --}}
                                    <x-slot name="topAction">
                                            <form action="{{ route('wishlist.destroy', $product->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-2xl hover:scale-125 transition-transform" title="Eliminar de favoritos">
                                                ❌
                                            </button>
                                        </form>
                                    </x-slot>

                                    {{-- Slot para acciones personalizadas en el footer --}}
                                    <x-slot name="actions">
                                        <div class="flex gap-2">
                                            <form action="{{ route('cart.store') }}" method="POST" class="flex-1">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <button type="submit" class="w-full btn-primary">
                                                    🛒 Añadir al Carrito
                                                </button>
                                            </form>
                                            <a href="{{ route('products.show', $product->id) }}" class="border border-gold/30 text-silver px-4 py-2 rounded-lg hover:bg-graphite transition">
                                                Ver
                                            </a>
                                        </div>
                                    </x-slot>
                                </x-product-card>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>