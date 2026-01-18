@extends('layouts.public')
@section('content')
<div class="container mx-auto px-4 py-8">
 <h1 class="text-3xl font-bold mb-8">🛒 Carrito de Compras</h1>
 @if($cartProducts->isEmpty())
 <div class="bg-white rounded-lg shadow-lg p-8 text-center">
 <div class="text-6xl mb-4">🛒</div>
 <h2 class="text-2xl font-bold text-gray-800 mb-2">Tu carrito está
vacío</h2>
 <p class="text-gray-600 mb-6">¡Añade productos para comenzar tu
compra!</p>
 <a href="{{ route('products.index') }}"
 class="inline-block bg-primary-600 text-white px-6 py-3 rounded-lg
hover:bg-primary-700 transition">
 Ver Productos
 </a>
</div>
 @else
 <div class="bg-white rounded-lg shadow-lg overflow-hidden">
 <table class="w-full">
 <thead class="bg-gray-50">
 <tr>
 <th class="px-6 py-4 text-left text-sm font-semibold textgray-700">Producto</th>
 <th class="px-6 py-4 text-left text-sm font-semibold textgray-700">Precio</th>
 <th class="px-6 py-4 text-left text-sm font-semibold textgray-700">Cantidad</th>
 <th class="px-6 py-4 text-left text-sm font-semibold textgray-700">Subtotal</th>
 </tr>
  </thead>
 <tbody class="divide-y divide-gray-200">
 @php
 $total = 0;
 @endphp
 @foreach($cartProducts as $product)
 @php
 $subtotal = $product->final_price * $product->pivot->quantity;
 $total += $subtotal;
 @endphp
 <tr class="hover:bg-gray-50">
 <td class="px-6 py-4">
 <div class="flex items-center">
 <div class="text-3xl mr-4">📦</div>
 <div>
 <div class="font-semibold text-gray-900">
{{ $product->name }}</div>
 <div class="text-sm text-gray-600">{{
$product->category->name }}</div>
 @if($product->offer)
 <span class="inline-block bg-orange-100 text-orange-800 text-xs px-2 py-1 rounded-full mt-1">
 🏷 -{{ $product->offer->discount_percentage }}%
 </span>
 @endif
 </div>
 </div>
 </td>
<td class="px-6 py-4">
 @if($product->offer)
 <div>
 <span class="text-sm text-gray-400 linethrough">€{{ number_format($product->price, 2) }}</span>
 <div class="font-semibold text-orange600">€{{ number_format($product->final_price, 2) }}</div>
 </div>
 @else
 <div class="font-semibold text-gray-900">€{{
number_format($product->price, 2) }}</div>
 @endif
 </td>
<td class="px-6 py-4">
 <span class="inline-block bg-gray-100 px-3 py-1
rounded">
 {{ $product->pivot->quantity }}
 </span>
 </td>
<td class="px-6 py-4 font-semibold text-gray-900">
 €{{ number_format($subtotal, 2) }}
 </td>
  </tr>
 @endforeach
 </tbody>
 <tfoot class="bg-gray-50">
 <tr>
 <td colspan="3" class="px-6 py-4 text-right font-semibold
text-gray-700">Total:</td>
 <td class="px-6 py-4 font-bold text-xl text-primary-600">€
{{ number_format($total, 2) }}</td>
 </tr>
 </tfoot>
 </table>
 </div>
 <div class="mt-6 flex justify-between">
 <a href="{{ route('products.index') }}"
 class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition">
 ← Seguir Comprando
 </a>
 <button class="bg-primary-600 text-white px-6 py-3 rounded-lg
hover:bg-primary-700 transition">
 Proceder al Pago →
 </button>
 </div>
@endif
</div>
@endsection