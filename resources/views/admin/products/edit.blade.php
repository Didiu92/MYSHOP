<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Producto') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ 
        lightboxImage: null,
        openLightbox(image) {
            this.lightboxImage = image;
        }
    }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        {{-- Nombre del Producto --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Producto *</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('name') border-red-500 @enderror" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Descripción --}}
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Descripción *</label>
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('description') border-red-500 @enderror" required>{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Imagen del Producto --}}
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700">Imagen del Producto</label>
                            @if ($product->image)
                                <div class="my-2">
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="Imagen actual"
                                         @click="openLightbox('{{ asset('storage/' . $product->image) }}')"
                                         class="h-24 w-24 object-cover rounded-md cursor-pointer hover:opacity-80 transition"
                                         style="cursor: pointer;">
                                    <p class="text-xs text-gray-500 mt-1">Imagen actual. Sube una nueva para reemplazarla. (Click para ampliar)</p>
                                </div>
                            @endif
                            <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('image') border-red-500 @enderror">
                            <p class="mt-1 text-xs text-gray-500">Formatos permitidos: JPG, PNG, WEBP. Tamaño máximo: 2MB</p>
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Precio --}}
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700">Precio (€) *</label>
                            <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('price') border-red-500 @enderror" required>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Categoría --}}
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Categoría *</label>
                            <select id="category_id" name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('category_id') border-red-500 @enderror" required>
                                <option value="">Selecciona una categoría</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Oferta (Opcional) --}}
                        <div>
                            <label for="offer_id" class="block text-sm font-medium text-gray-700">Oferta (Opcional)</label>
                            <select id="offer_id" name="offer_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('offer_id') border-red-500 @enderror">
                                <option value="">Sin oferta</option>
                                @foreach($offers as $offer)
                                    <option value="{{ $offer->id }}" {{ old('offer_id', $product->offer_id) == $offer->id ? 'selected' : '' }}>
                                        {{ $offer->name }} (-{{ $offer->discount_percentage }}%)
                                    </option>
                                @endforeach
                            </select>
                            @error('offer_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Botones de Acción --}}
                        <div class="flex justify-end space-x-4 pt-4">
                            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition">
                                Cancelar
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                Actualizar Producto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Lightbox Modal -->
        <div x-show="lightboxImage" 
             x-cloak
             @click="lightboxImage = null"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75 p-4"
             style="display: none; animation: fadeIn 0.2s ease-in;">
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
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
        </style>
    </div>
</x-app-layout>