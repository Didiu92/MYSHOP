@extends('layouts.app')

@section('title', $category->name . ' - Mi Tienda')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $category->name }}</h1>
            <p class="text-gray-600 mb-4">{{ $category->description }}</p>
            <a href="{{ route('categories.index') }}" 
               class="text-primary-600 hover:text-primary-700 transition">
                ← Volver a Categorías
            </a>
        </div>

        @if($categoryProducts->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($categoryProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
    @else
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">No hay productos en esta categoría.</p>
            </div>
    @endif
</div>
@endsection