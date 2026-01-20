@extends('layouts.public')
@section('title', 'Todos los Productos - Mi Tienda')
@push('styles')
 <style>
 .product-grid {
 display: grid;
 grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
 gap: 2rem;
 }
 </style>
@endpush
@section('content')
 <div class="container mx-auto px-6 py-8">
 <div class="mb-8">
 <h1 class="text-3xl font-bold text-gold mb-4">Todos los Productos</h1>
 <p class="text-silver">Descubre nuestra amplia gama de productos de
calidad.</p>
 </div>
 <div class="product-grid">
 @forelse($products as $product)
 <x-product-card :product="$product" />
 @empty
 <div class="col-span-full text-center py-12">
 <p class="text-gray-500 text-lg">No hay productos disponibles.
</p>
</div>
 @endforelse
 </div>
 </div>
@endsection