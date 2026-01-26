<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gold leading-tight">
            {{ __('Crear Nuevo Producto') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ 
        previewImages: [],
        selectedFiles: [],
        draggedIndex: null,
        previewFiles(event) {
            this.previewImages = [];
            this.selectedFiles = Array.from(event.target.files);
            for (let i = 0; i < this.selectedFiles.length; i++) {
                this.previewImages.push(URL.createObjectURL(this.selectedFiles[i]));
            }
        },
        dragStart(index) {
            this.draggedIndex = index;
        },
        dragOver(event) {
            event.preventDefault();
        },
        drop(index) {
            if (this.draggedIndex !== null && this.draggedIndex !== index) {
                // Reordenar previews
                const draggedPreview = this.previewImages[this.draggedIndex];
                this.previewImages.splice(this.draggedIndex, 1);
                this.previewImages.splice(index, 0, draggedPreview);
                
                // Reordenar archivos
                const draggedFile = this.selectedFiles[this.draggedIndex];
                this.selectedFiles.splice(this.draggedIndex, 1);
                this.selectedFiles.splice(index, 0, draggedFile);
                
                // Actualizar el input de archivos
                this.updateFileInput();
            }
            this.draggedIndex = null;
        },
        updateFileInput() {
            const dataTransfer = new DataTransfer();
            this.selectedFiles.forEach(file => {
                dataTransfer.items.add(file);
            });
            document.getElementById('images').files = dataTransfer.files;
        }
    }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-gray-900 border-b border-gold/10">
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        {{-- Nombre del Producto --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gold">Nombre del Producto *</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gold/20 shadow-sm focus:border-gold focus:ring focus:ring-gold/20 focus:ring-opacity-50 @error('name') border-red-500 @enderror" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Descripción --}}
                        <div>
                            <label for="description" class="block text-sm font-medium text-gold">Descripción *</label>
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gold/20 shadow-sm focus:border-gold focus:ring focus:ring-gold/20 focus:ring-opacity-50 @error('description') border-red-500 @enderror" required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Imágenes del Producto --}}
                        <div>
                            <label for="images" class="block text-sm font-medium text-gold">Imágenes del Producto (Múltiples)</label>
                            
                            {{-- Vista previa --}}
                            <div x-show="previewImages.length > 0" x-cloak class="my-3">
                                <p class="text-xs text-silver font-medium mb-2">Vista previa (arrastra para reordenar):</p>
                                <div class="flex gap-3 overflow-x-auto pb-2">
                                    <template x-for="(image, index) in previewImages" :key="index">
                                        <div class="relative flex-shrink-0 cursor-move"
                                             draggable="true"
                                             @dragstart="dragStart(index)"
                                             @dragover="dragOver($event)"
                                             @drop="drop(index)">
                                            <img :src="image" 
                                                 alt="Vista previa"
                                                 class="h-24 w-24 object-cover rounded-md border-2 border-gold/20"
                                                 :class="{ 'opacity-50': draggedIndex === index }">
                                            <span class="absolute top-0 right-0 bg-gold text-graphite text-xs px-1 py-0.5 rounded-bl-md font-semibold" x-text="index + 1"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            
                            <input type="file" 
                                   id="images" 
                                   name="images[]" 
                                   multiple
                                   accept="image/jpeg,image/png,image/jpg,image/webp" 
                                   @change="previewFiles($event)"
                                   class="mt-1 block w-full text-sm text-silver file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gold/10 file:text-gold hover:file:bg-gold hover:file:text-gray-900 file:transition-colors @error('images.*') border-red-500 @enderror">
                            <p class="mt-1 text-xs text-gray-500">Puedes seleccionar múltiples imágenes. Formatos: JPG, PNG, WEBP. Máximo 2MB cada una</p>
                            @error('images.*')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Precio --}}
                        <div>
                            <label for="price" class="block text-sm font-medium text-gold">Precio (€) *</label>
                            <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gold/20 shadow-sm focus:border-gold focus:ring focus:ring-gold/20 focus:ring-opacity-50 @error('price') border-red-500 @enderror" required>
                            @error('price')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Categoría --}}
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gold">Categoría *</label>
                            <select id="category_id" name="category_id" class="mt-1 block w-full rounded-md border-gold/20 shadow-sm focus:border-gold focus:ring focus:ring-gold/20 focus:ring-opacity-50 @error('category_id') border-red-500 @enderror" required>
                                <option value="">Selecciona una categoría</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Oferta (Opcional) --}}
                        <div>
                            <label for="offer_id" class="block text-sm font-medium text-gold">Oferta (Opcional)</label>
                            <select id="offer_id" name="offer_id" class="mt-1 block w-full rounded-md border-gold/20 shadow-sm focus:border-gold focus:ring focus:ring-gold/20 focus:ring-opacity-50 @error('offer_id') border-red-500 @enderror">
                                <option value="">Sin oferta</option>
                                @foreach($offers as $offer)
                                    <option value="{{ $offer->id }}" {{ old('offer_id') == $offer->id ? 'selected' : '' }}>
                                        {{ $offer->name }} (-{{ $offer->discount_percentage }}%)
                                    </option>
                                @endforeach
                            </select>
                            @error('offer_id')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Botones de Acción --}}
                        <div class="flex justify-end space-x-4 pt-4">
                            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-gray-300 text-gold rounded-md hover:bg-graphite transition">
                                Cancelar
                            </a>
                            <button type="submit" class="px-4 py-2 bg-gold text-graphite font-semibold rounded-md hover:bg-gold/80 transition">
                                Crear Producto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>