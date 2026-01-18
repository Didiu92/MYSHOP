@extends('layouts.public')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">🛒 Carrito de Compras</h1>

    @if($cartProducts->isEmpty())
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">
            <div class="text-6xl mb-4">🛒</div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Tu carrito está vacío</h2>
            <p class="text-gray-600 mb-6">¡Añade productos para comenzar tu compra!</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition">
                Ver Productos
            </a>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Producto</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Precio</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Cantidad</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Subtotal</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Acciones</th>
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
                        
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}" 
                                             class="h-16 w-16 object-cover rounded-md mr-4">
                                    @else
                                        <div class="h-16 w-16 bg-gray-100 flex items-center justify-center rounded-md text-4xl mr-4">
                                            📦
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-semibold text-gray-900">{{ $product->name }}</div>
                                        <div class="text-sm text-gray-600">{{ $product->category->name }}</div>
                                        @if($product->offer)
                                            <span class="inline-block bg-orange-100 text-orange-800 text-xs px-2 py-1 rounded-full mt-1">
                                                🏷️ -{{ $product->offer->discount_percentage }}%
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($product->offer)
                                    <div>
                                        <span class="text-sm text-gray-400 line-through">€{{ number_format($product->price, 2) }}</span>
                                        <div class="font-semibold text-orange-600">€{{ number_format($product->final_price, 2) }}</div>
                                    </div>
                                @else
                                    <div class="font-semibold text-gray-900">€{{ number_format($product->final_price, 2) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                {{-- FORMULARIO PARA ACTUALIZAR CANTIDAD --}}
                                <form action="{{ route('cart.update', $product->id) }}" method="POST" class="flex items-center justify-center">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantity" value="{{ $product->quantity }}" min="1" class="w-20 text-center border-gray-300 rounded-md shadow-sm">
                                    <button type="submit" class="ml-2 p-1 text-indigo-600 hover:text-indigo-800" title="Actualizar cantidad">🔄</button>
                                </form>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900">€{{ number_format($subtotal, 2) }}</td>
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
                        <td class="px-6 py-4 font-bold text-xl text-primary-600">€{{ number_format($total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="mt-6 flex justify-between items-center">
            <a href="{{ route('products.index') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition">
                ← Seguir Comprando
            </a>
            {{-- FORMULARIO PARA FINALIZAR COMPRA --}}
            <form action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-green-600 text-white font-bold px-6 py-3 rounded-lg hover:bg-green-700 transition">
                    Realizar Pedido →
                </button>
            </form>
        </div>
    @endif
</div>
@endsection