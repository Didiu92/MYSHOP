@extends('layouts.public')
@section('title', 'Categorías - Mi Tienda')
@section('content')
 <div class="container mx-auto px-6 py-8">
 <div class="mb-8">
 <h1 class="text-3xl font-bold text-gold mb-4">Nuestras
Categorías</h1>
 <p class="text-silver">Explora nuestros productos por categoría.</p>
 </div>
 <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
 @forelse($categories as $category)
 <x-category-card :category="$category" />
 @empty
 <div class="col-span-full text-center py-12">
 <p class="text-silver/70 text-lg">No hay categorías
disponibles.</p>
 </div>
 @endforelse
 </div>
 </div>
@endsection