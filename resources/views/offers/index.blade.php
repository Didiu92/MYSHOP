@extends('layouts.public')
@section('title', 'Ofertas - Mi Tienda')
@section('content')
 <div class="container mx-auto px-6 py-8">
 <div class="mb-8">
    <h1 class="text-3xl font-bold text-gold mb-4">Ofertas
Especiales</h1>
 <p class="text-silver">Descubre nuestras mejores ofertas y
descuentos.</p>
 </div>
 <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
 @forelse($offers as $offer)
 <div class="card p-6 border-l-4 border-copper">
 <h3 class="text-xl font-bold text-gold mb-2">{{  
$offer['name'] }}</h3>
 <p class="text-silver mb-4">{{ $offer['description'] }}</p>
 <div class="text-2xl font-bold text-copper mb-4">
 {{ $offer['discount_percentage'] }}% de descuento
 </div>
 <a href="{{ route('offers.show', $offer['id']) }}"
 class="btn-primary block text-center">
 Ver Productos
 </a>
 </div>
 @empty
 <div class="col-span-full text-center py-12">
 <p class="text-silver/70 text-lg">No hay ofertas disponibles.
</p>
 </div>
 @endforelse
 </div>
 </div>
@endsection