@extends('layouts.public')

@section('title', $offer->name . ' - Aristocats')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gold mb-2">{{ $offer->name }}</h1>
                <p class="text-silver">{{ $offer->description }}</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center bg-orange-100 text-orange-800 px-4 py-2 rounded-full font-semibold">
                    -{{ $offer->discount_percentage }}% de descuento
                </span>
                
                {{-- Botones de Admin: Editar y Eliminar --}}
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.offers.edit', $offer->id) }}" 
                           class="bg-gold text-ebony px-4 py-2 rounded-lg hover:bg-copper hover:text-ebony transition text-sm font-semibold">
                            ✏️ Editar
                        </a>
                        <form action="{{ route('admin.offers.destroy', $offer->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta oferta?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-graphite text-red-500 border border-red-500 px-4 py-2 rounded-lg hover:bg-red-500 hover:text-white transition text-sm font-semibold">
                                🗑️ Eliminar
                            </button>
                        </form>
                    @endif
                @endauth
                
                <a href="{{ route('offers.index') }}" 
                   class="text-gold hover:text-copper transition">
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
                <p class="text-silver/70 text-lg">No hay productos asociados a esta oferta.</p>
            </div>
        @endif
    </div>
@endsection