@extends('layouts.public')

@section('title', $offer->name . ' - Mi Tienda')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $offer->name }}</h1>
                <p class="text-gray-600">{{ $offer->description }}</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center bg-orange-100 text-orange-800 px-4 py-2 rounded-full font-semibold">
                    -{{ $offer->discount_percentage }}% de descuento
                </span>
                <a href="{{ route('offers.index') }}" 
                   class="text-primary-600 hover:text-primary-700 transition">
                    &larr; Volver a Ofertas
                </a>
            </div>
        </div>
        
        @if($offerProducts->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($offerProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">No hay productos asociados a esta oferta.</p>
            </div>
        @endif
    </div>
@endsection