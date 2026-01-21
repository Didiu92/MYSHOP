<x-app-layout x-data="{ 
    lightboxImage: null,
    openLightbox(image) {
        this.lightboxImage = image;
    }
}">
    @push('styles')
    <style>
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
            background: #E5E7EB;
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
            color: #374151;
            font-weight: 500;
        }
    </style>
    @endpush
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
            <!-- Filtros completos -->
            <div class="mb-4">
                <form action="{{ route('admin.products.index') }}" method="GET" id="adminFilterForm" x-data="{ 
                    priceMin: {{ request('price_min') ?: '0' }}, 
                    priceMax: {{ request('price_max') ?: '500' }}
                }">
                    <!-- Filtros en una línea -->
                    <div class="flex gap-2 mb-3 flex-wrap items-end">
                        <!-- Filtro por categoría -->
                        <div class="flex-1 min-w-[120px]">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Categoría</label>
                            <select name="category" onchange="document.getElementById('adminFilterForm').submit()" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="">Todas</option>
                                @foreach(\App\Models\Category::all() as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filtro por oferta -->
                        <div class="flex-1 min-w-[120px]">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Oferta</label>
                            <select name="has_offer" onchange="document.getElementById('adminFilterForm').submit()" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="">Todos</option>
                                <option value="yes" {{ request('has_offer') === 'yes' ? 'selected' : '' }}>Con oferta</option>
                                <option value="no" {{ request('has_offer') === 'no' ? 'selected' : '' }}>Sin oferta</option>
                            </select>
                        </div>

                        <!-- Filtro por rango de precio con slider -->
                        <div class="flex-1 min-w-[220px]">
                            <label class="block text-xs font-medium text-gray-700 mb-2">Rango de Precio</label>
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
                                       @change="document.getElementById('adminFilterForm').submit()"
                                       class="price-min">
                                <input type="range" 
                                       name="price_max_input"
                                       min="0" 
                                       max="500" 
                                       step="10"
                                       x-model.number="priceMax"
                                       @input="if(priceMax < priceMin) priceMax = priceMin"
                                       @change="document.getElementById('adminFilterForm').submit()"
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
                            <label class="block text-xs font-medium text-gray-700 mb-1">Ordenar por</label>
                            <select name="sort_by" onchange="document.getElementById('adminFilterForm').submit()" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="">Más recientes</option>
                                <option value="name_asc" {{ request('sort_by') === 'name_asc' ? 'selected' : '' }}>Nombre (A-Z)</option>
                                <option value="name_desc" {{ request('sort_by') === 'name_desc' ? 'selected' : '' }}>Nombre (Z-A)</option>
                                <option value="price_asc" {{ request('sort_by') === 'price_asc' ? 'selected' : '' }}>Precio (menor a mayor)</option>
                                <option value="price_desc" {{ request('sort_by') === 'price_desc' ? 'selected' : '' }}>Precio (mayor a menor)</option>
                                <option value="oldest" {{ request('sort_by') === 'oldest' ? 'selected' : '' }}>Más antiguos</option>
                            </select>
                        </div>

                        <!-- Botón limpiar -->
                        @if(request('search') || request('category') || request('has_offer') || request('price_min') || request('price_max') || request('sort_by'))
                            <a href="{{ route('admin.products.index') }}" class="px-3 py-1.5 text-sm bg-gray-400 text-white rounded hover:bg-gray-500 transition whitespace-nowrap">
                                Limpiar filtros
                            </a>
                        @endif
                    </div>

                    <!-- Búsqueda por texto -->
                    <div class="flex gap-2">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Buscar productos por nombre, descripción o categoría..."
                               class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Buscar
                        </button>
                    </div>
                </form>
            </div>

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