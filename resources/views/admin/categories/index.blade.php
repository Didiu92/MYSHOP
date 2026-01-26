<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gold leading-tight">Categorías</h2>
            @if(auth()->user()?->isAdmin())
                <a href="{{ route('admin.categories.create') }}" class="btn-primary">Nueva categoría</a>
            @else
                <span class="text-sm text-silver">Vista solo lectura</span>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Barra de búsqueda -->
            <div class="mb-4">
                <form action="{{ route('admin.categories.index') }}" method="GET" class="flex gap-2">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Buscar categorías por nombre o descripción..."
                           class="flex-1 px-4 py-2 border border-gold/20 bg-gray-800 text-white rounded-lg focus:ring-2 focus:ring-gold focus:border-gold placeholder-gray-400">
                    <button type="submit" class="px-6 py-2 bg-gold text-ebony rounded-lg hover:bg-copper transition flex items-center gap-2 font-semibold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Buscar
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 bg-graphite text-silver rounded-lg hover:bg-graphite/80 transition">
                            Limpiar
                        </a>
                    @endif
                </form>
            </div>

            <div class="bg-gray-900 shadow sm:rounded-lg overflow-hidden border border-gold/10">
                <table class="min-w-full divide-y divide-gold/10">
                    <thead class="bg-gray-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gold uppercase tracking-wider">Imagen</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gold uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gold uppercase tracking-wider">Descripción</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gold uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-900 divide-y divide-gold/10">
                        @forelse($categories as $category)
                            <tr>
                                <td class="px-6 py-3 align-middle">
                                    @if($category->image)
                                        <div class="overflow-hidden rounded border border-gold/10 bg-gray-800 flex items-center justify-center" style="width:100px; height:100px;">
                                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <span class="text-silver text-sm">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $category->name }}</td>
                                <td class="px-6 py-4 text-silver">{{ Str::limit($category->description, 80) }}</td>
                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    @if(auth()->user()?->isAdmin())
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="px-2 py-1 inline-block bg-gold/10 text-gold rounded hover:bg-gold hover:text-ebony transition mr-4">Editar</a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar categoría?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2 py-1 inline-block bg-red-900/20 text-red-400 rounded hover:bg-red-600 hover:text-white transition">Eliminar</button>
                                        </form>
                                    @else
                                        <span class="text-silver text-sm">Solo lectura</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-6 text-center text-silver">No hay categorías.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
