@extends('layouts.public')
@section('title', 'Categorías - Mi Tienda')
@section('content')
 <div class="container mx-auto px-6 py-8">
 <div class="mb-8">
 <h1 class="text-3xl font-bold text-gold mb-4">Nuestras
Categorías</h1>
 <p class="text-silver mb-6">Explora nuestros productos por categoría.</p>
 
 <!-- Barra de búsqueda -->
 <form action="{{ route('categories.index') }}" method="GET" class="mb-6">
 <div class="flex gap-2">
 <input type="text" 
 name="search" 
 value="{{ $search }}"
 placeholder="Buscar categorías por nombre o descripción..."
 class="flex-1 px-4 py-3 bg-ebony border border-gray-600 rounded-lg text-silver placeholder-gray-500 focus:ring-2 focus:ring-gold focus:border-transparent transition">
 <button type="submit" class="btn-primary px-6 py-3 flex items-center gap-2">
 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
 </svg>
 Buscar
 </button>
 @if($search)
 <a href="{{ route('categories.index') }}" class="px-4 py-3 bg-gray-600 text-silver rounded-lg hover:bg-gray-500 transition">
 Limpiar
 </a>
 @endif
 </div>
 </form>
 </div>
 
 @if($search)
 <div class="mb-4 p-3 bg-blue-900/30 border border-blue-600 rounded-lg text-silver">
 Se encontraron <strong>{{ $categories->count() }}</strong> resultado(s) para "<strong>{{ $search }}</strong>"
 </div>
 @endif
 
 <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
 @forelse($categories as $category)
 <x-category-card :category="$category" />
 @empty
 <div class="col-span-full text-center py-12">
 <p class="text-silver/70 text-lg">
 @if($search)
 No se encontraron categorías para "{{ $search }}".
 @else
 No hay categorías disponibles.
 @endif
 </p>
 </div>
 @endforelse
 </div>
 </div>
@endsection