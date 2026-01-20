<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar oferta</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form action="{{ route('admin.offers.update', $offer) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" name="name" value="{{ old('name', $offer->name) }}" class="mt-1 input" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Descuento (%)</label>
                        <input type="number" step="0.01" name="discount_percentage" value="{{ old('discount_percentage', $offer->discount_percentage) }}" class="mt-1 input" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Descripción (opcional)</label>
                        <textarea name="description" rows="4" class="mt-1 input">{{ old('description', $offer->description) }}</textarea>
                    </div>
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.offers.index') }}" class="text-gray-600">Cancelar</a>
                        <button type="submit" class="btn-primary">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
