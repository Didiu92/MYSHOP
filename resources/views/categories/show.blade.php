@extends('layouts.public')

@section('title', $category->name . ' - Mi Tienda')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="mb-8 flex items-start justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gold mb-4">{{ $category->name }}</h1>
                <p class="text-silver mb-4">{{ $category->description }}</p>
            </div>
            
            {{-- Botones de Admin: Editar y Eliminar --}}
            @auth
                @if(auth()->user()->isAdmin())
                    <div class="flex gap-2">
                        <a href="{{ route('admin.categories.edit', $category->id) }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm">
                            ✏️ Editar
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta categoría?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition text-sm">
                                🗑️ Eliminar
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>

        <a href="{{ route('categories.index') }}" 
           class="text-primary-600 hover:text-primary-700 transition mb-6 inline-block">
            ← Volver a Categorías
        </a>

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