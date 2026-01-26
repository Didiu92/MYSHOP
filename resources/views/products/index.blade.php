@extends('layouts.public')
@section('title', 'Todos los Productos - Aristocats')
@push('styles')
 <style>
 .product-grid {
 display: grid;
 grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
 gap: 2rem;
 }
 
 .price-range-slider {
 position: relative;
 margin: 10px 0;
 }
 
 .price-range-slider input[type="range"] {
 position: absolute;
 width: 100%;
 height: 4px;
 top: 10px;
 border-radius: 2px;
 background: none;
 pointer-events: none;
 -webkit-appearance: none;
 }
 
 .price-range-slider input[type="range"]::-webkit-slider-thumb {
 -webkit-appearance: none;
 appearance: none;
 width: 16px;
 height: 16px;
 border-radius: 50%;
 background: #FFD700;
 cursor: pointer;
 pointer-events: auto;
 box-shadow: 0 0 4px rgba(255, 215, 0, 0.5);
 }
 
 .price-range-slider input[type="range"]::-moz-range-thumb {
 width: 16px;
 height: 16px;
 border-radius: 50%;
 background: #FFD700;
 cursor: pointer;
 pointer-events: auto;
 border: none;
 box-shadow: 0 0 4px rgba(255, 215, 0, 0.5);
 }
 
 .price-range-slider .track {
 position: absolute;
 width: 100%;
 height: 4px;
 top: 10px;
 border-radius: 2px;
 background: #3a3a3a;
 pointer-events: none;
 }
 
 .price-range-slider .range-progress {
 position: absolute;
 height: 4px;
 top: 10px;
 border-radius: 2px;
 background: #FFD700;
 pointer-events: none;
 }
 
 .price-display {
 display: flex;
 justify-content: space-between;
 align-items: center;
 margin-top: 32px;
 padding: 0 2px;
 font-size: 13px;
 color: #E8E8E8;
 font-weight: 500;
 }
 </style>
@endpush
@section('content')
 <div class="container mx-auto px-6 py-8">
 <div class="mb-6">
 <h1 class="text-3xl font-bold text-gold mb-2">Todos los Productos</h1>
 <p class="text-silver mb-4">Descubre nuestra amplia gama de productos de calidad.</p>
 
 <!-- Formulario de búsqueda y filtros -->
 <form action="{{ route('products.index') }}" method="GET" id="filterForm" x-data="{ 
 priceMin: {{ $priceMin ?: '0' }}, 
 priceMax: {{ $priceMax ?: '500' }}
 }">
 <!-- Filtros en una línea -->
 <div class="flex gap-2 mb-6 flex-wrap items-end">
 <!-- Filtro por categoría -->
 <div class="flex-1 min-w-[120px]">
 <label class="block text-xs font-medium text-silver mb-1">Categoría</label>
 <select name="category" onchange="document.getElementById('filterForm').submit()" class="w-full px-2 py-1.5 text-sm bg-ebony border border-gray-600 rounded text-silver focus:ring-2 focus:ring-gold focus:border-transparent transition">
 <option value="">Todas</option>
 @foreach($categories as $cat)
 <option value="{{ $cat->id }}" {{ $category == $cat->id ? 'selected' : '' }}>
 {{ $cat->name }}
 </option>
 @endforeach
 </select>
 </div>
 
 <!-- Filtro por oferta -->
 <div class="flex-1 min-w-[120px]">
 <label class="block text-xs font-medium text-silver mb-1">Oferta</label>
 <select name="has_offer" onchange="document.getElementById('filterForm').submit()" class="w-full px-2 py-1.5 text-sm bg-ebony border border-gray-600 rounded text-silver focus:ring-2 focus:ring-gold focus:border-transparent transition">
 <option value="">Todos</option>
 <option value="yes" {{ $hasOffer === 'yes' ? 'selected' : '' }}>Con oferta</option>
 <option value="no" {{ $hasOffer === 'no' ? 'selected' : '' }}>Sin oferta</option>
 </select>
 </div>
 
 <!-- Filtro por rango de precio con slider -->
 <div class="flex-1 min-w-[220px]">
 <label class="block text-xs font-medium text-silver mb-2">Rango de Precio</label>
 <div class="price-range-slider">
 <div class="track"></div>
 <div class="range-progress" :style="{ left: (priceMin / 500 * 100) + '%', right: (100 - (priceMax / 500 * 100)) + '%' }"></div>
 <input type="range" 
 name="price_min_input"
 min="0" 
 max="500" 
 step="10"
 x-model.number="priceMin"
 @input="if(priceMin > priceMax) priceMin = priceMax"
 @change="document.getElementById('filterForm').submit()"
 class="price-min">
 <input type="range" 
 name="price_max_input"
 min="0" 
 max="500" 
 step="10"
 x-model.number="priceMax"
 @input="if(priceMax < priceMin) priceMax = priceMin"
 @change="document.getElementById('filterForm').submit()"
 class="price-max">
 </div>
 <div class="price-display">
 <span>€<span x-text="priceMin"></span></span>
 <span>€<span x-text="priceMax"></span></span>
 </div>
 <!-- Hidden inputs para enviar los valores -->
 <input type="hidden" name="price_min" :value="priceMin">
 <input type="hidden" name="price_max" :value="priceMax">
 </div>
 
 <!-- Filtro de ordenamiento -->
 <div class="flex-1 min-w-[150px]">
 <label class="block text-xs font-medium text-silver mb-1">Ordenar por</label>
 <select name="sort_by" onchange="document.getElementById('filterForm').submit()" class="w-full px-2 py-1.5 text-sm bg-ebony border border-gray-600 rounded text-silver focus:ring-2 focus:ring-gold focus:border-transparent transition">
 <option value="">Más recientes</option>
 <option value="name_asc" {{ $sortBy === 'name_asc' ? 'selected' : '' }}>Nombre (A-Z)</option>
 <option value="name_desc" {{ $sortBy === 'name_desc' ? 'selected' : '' }}>Nombre (Z-A)</option>
 <option value="price_asc" {{ $sortBy === 'price_asc' ? 'selected' : '' }}>Precio (menor a mayor)</option>
 <option value="price_desc" {{ $sortBy === 'price_desc' ? 'selected' : '' }}>Precio (mayor a menor)</option>
 <option value="oldest" {{ $sortBy === 'oldest' ? 'selected' : '' }}>Más antiguos</option>
 </select>
 </div>
 
 <!-- Botón limpiar -->
 @if($search || $category || $hasOffer || $priceMin || $priceMax || $sortBy)
 <div class="flex gap-2">
 <a href="{{ route('products.index') }}" class="px-3 py-1.5 text-sm bg-gray-600 text-silver rounded hover:bg-gray-500 transition whitespace-nowrap">
 Limpiar filtros
 </a>
 </div>
 @endif
 </div>
 
 <!-- Búsqueda por texto -->
 <div class="flex gap-2">
 <input type="text" 
 name="search" 
 value="{{ $search }}"
 placeholder="Buscar productos por nombre, descripción o categoría..."
 class="flex-1 px-3 py-2 text-sm bg-ebony border border-gray-600 rounded text-silver placeholder-gray-500 focus:ring-2 focus:ring-gold focus:border-transparent transition">
 <button type="submit" class="btn-primary px-4 py-2 text-sm flex items-center gap-1">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
 </svg>
 Buscar
 </button>
 </div>
 </form>
 </div>
 
 @if($search || $category || $hasOffer || $priceMin || $priceMax)
 <div class="mb-4 p-2 bg-blue-900/30 border border-blue-600 rounded text-silver text-sm">
 <strong>{{ $products->count() }}</strong> resultado(s)
 @if($search) - "{{ $search }}" @endif
 @if($category) - {{ $categories->find($category)->name ?? 'N/A' }} @endif
 @if($hasOffer) - {{ $hasOffer === 'yes' ? 'con oferta' : 'sin oferta' }} @endif
 @if($priceMin || $priceMax) - €{{ $priceMin ?? '0' }}-€{{ $priceMax ?? '∞' }} @endif
 </div>
 @endif
 
 <div class="product-grid">
 @forelse($products as $product)
 <x-product-card :product="$product" />
 @empty
 <div class="col-span-full text-center py-12">
 <p class="text-gray-500 text-lg">
 @if($search || $category || $hasOffer || $priceMin || $priceMax)
 No se encontraron productos con los filtros aplicados.
 @else
 No hay productos disponibles.
 @endif
 </p>
 </div>
 @endforelse
 </div>
 </div>
@endsection