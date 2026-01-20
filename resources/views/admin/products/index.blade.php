<x-app-layout x-data="{ 
    lightboxImage: null,
    openLightbox(image) {
        this.lightboxImage = image;
    }
}">
    <x-slot name="header">
        <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Productos') }}
        </h2>
            @if(auth()->user()?->isAdmin())
            <a href="{{ route('admin.products.create') }}" class="inline-flex items-center px-4 py-2 border rounded-md font-semibold text-xs uppercase hover:bg-gray-100 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Crear Nuevo Producto
            </a>
            @else
                <span class="text-sm text-gray-500">Vista solo lectura</span>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imagen</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($products as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" 
                                                 alt="{{ $product->name }}"
                                                 @click="openLightbox('{{ asset('storage/' . $product->image) }}')"
                                                 class="h-16 w-16 object-cover rounded-md shadow-sm cursor-pointer hover:opacity-80 transition"
                                                 style="cursor: pointer;">
                                        @else
                                            <div class="h-16 w-16 bg-gray-100 flex items-center justify-center rounded-md text-4xl">
                                                📦
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            <a href="{{ route('products.show', $product->id) }}" class="hover:underline">
                                                {{ $product->name }}
                                            </a>
                                        </div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($product->description, 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $product->category->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">€{{ number_format($product->price, 2) }}</div>
                                        @if($product->offer)
                                            <div class="text-xs text-orange-600">
                                                -{{ $product->offer->discount_percentage }}% descuento
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @if(auth()->user()?->isAdmin())
                                            <a href="{{ route('admin.products.edit', $product) }}" 
                                               class="text-indigo-600 hover:text-indigo-900 mr-4">
                                                Editar
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product) }}" 
                                                  method="POST" 
                                                  class="inline-block" 
                                                  onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-sm">Solo lectura</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="text-gray-400 text-4xl mb-4">📦</div>
                                        <p class="text-gray-500 text-lg font-medium">No hay productos para mostrar</p>
                                        <p class="text-gray-400 text-sm mt-2">Crea tu primer producto usando el botón de arriba</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Lightbox Modal -->
    <div x-show="lightboxImage" 
         x-cloak
         @click="lightboxImage = null"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75 p-4"
         style="animation: fadeIn 0.2s ease-in;">
        <div class="relative bg-white rounded-lg shadow-2xl p-4 max-w-2xl" @click.stop>
            <button @click="lightboxImage = null" 
                    class="absolute -top-4 -right-4 text-white bg-red-600 rounded-full w-10 h-10 flex items-center justify-center hover:bg-red-700 transition font-bold text-2xl shadow-lg">
                ✕
            </button>
            <img :src="lightboxImage" 
                 alt="Imagen ampliada"
                 class="w-full max-h-screen object-contain">
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</x-app-layout>