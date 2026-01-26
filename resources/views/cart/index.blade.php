@extends('layouts.public')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">🛒 Carrito de Compras</h1>

    @if($cartProducts->isEmpty())
        <div class="card p-8 text-center">
            <div class="text-6xl mb-4">🛒</div>
            <h2 class="text-2xl font-bold text-gold mb-2">Tu carrito está vacío</h2>
            <p class="text-silver mb-6">¡Añade productos para comenzar tu compra!</p>
            <a href="{{ route('products.index') }}" class="inline-block btn-primary">
                Ver Productos
            </a>
        </div>
    @else
        <div class="card overflow-hidden">
            <table class="w-full">
                <thead class="bg-graphite">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-silver">Producto</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-silver">Precio</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-silver">Cantidad</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-silver">Subtotal</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-silver">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php $total = 0; @endphp
                    
                    @foreach($cartProducts as $product)
                        @php
                            // Calculamos el subtotal usando el accessor final_price
                            $subtotal = $product->final_price * $product->quantity;
                            $total += $subtotal;
                        @endphp
                        
                        <tr class="hover:bg-graphite" x-data="{
                            quantity: {{ $product->quantity }},
                            productId: {{ $product->id }},
                            updating: false,
                            updateQuantity() {
                                if (this.updating) return;
                                this.updating = true;
                                fetch('{{ route('cart.update', $product->id) }}', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                        'Accept': 'application/json',
                                        'Content-Type': 'application/json',
                                        'X-Requested-With': 'XMLHttpRequest'
                                    },
                                    body: JSON.stringify({
                                        _method: 'PUT',
                                        quantity: this.quantity
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    this.updating = false;
                                    if (data.success) {
                                        window.location.reload();
                                    }
                                })
                                .catch(e => {
                                    this.updating = false;
                                    console.error('Error:', e);
                                });
                            }
                        }">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($product->images->count() > 0)
                                        <img src="{{ asset('storage/' . $product->images->first()->path) }}" 
                                             alt="{{ $product->name }}" 
                                             class="h-16 w-16 object-cover rounded-md mr-4">
                                    @elseif($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}" 
                                             class="h-16 w-16 object-cover rounded-md mr-4">
                                    @else
                                        <div class="h-16 w-16 bg-gray-700 flex items-center justify-center rounded-md text-4xl mr-4">
                                            📦
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-semibold text-gold">{{ $product->name }}</div>
                                        <div class="text-sm text-silver">{{ $product->category->name }}</div>
                                        @if($product->offer)
                                            <span class="inline-block bg-copper/20 text-copper text-xs px-2 py-1 rounded-full mt-1">
                                                🏷️ -{{ $product->offer->discount_percentage }}%
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($product->offer)
                                    <div>
                                        <span class="text-sm text-silver/60 line-through">€{{ number_format($product->price, 2) }}</span>
                                        <div class="font-semibold text-copper">€{{ number_format($product->final_price, 2) }}</div>
                                    </div>
                                @else
                                        <div class="font-semibold text-gold">€{{ number_format($product->final_price, 2) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center">
                                    <input type="number" 
                                           x-model.number="quantity" 
                                           @change="updateQuantity()" 
                                           min="1" 
                                           :disabled="updating"
                                           class="w-20 text-center border-gray-600 bg-ebony text-silver rounded-md shadow-sm focus:ring-gold focus:border-gold">
                                    <span x-show="updating" class="ml-2 text-gold">⏳</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gold">€{{ number_format($subtotal, 2) }}</td>
                            <td class="px-6 py-4 text-center">
                                {{-- FORMULARIO PARA ELIMINAR --}}
                                <form action="{{ route('cart.destroy', $product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Eliminar producto">🗑️ Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-right font-semibold text-gray-700">Total:</td>
                        <td class="px-6 py-4 font-bold text-xl text-gold">€{{ number_format($total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="mt-6 flex justify-between items-center">
            <a href="{{ route('products.index') }}" class="border border-gold/30 text-silver px-6 py-3 rounded-lg hover:bg-graphite transition">
                ← Seguir Comprando
            </a>
            {{-- FORMULARIO PARA FINALIZAR COMPRA --}}
            <form action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-primary">
                    Realizar Pedido →
                </button>
            </form>
        </div>
    @endif
</div>
@endsection