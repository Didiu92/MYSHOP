{{-- Sistema de Notificaciones Flash --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm relative" role="alert">
            <button type="button" class="absolute top-2 right-2 text-green-700 hover:text-green-900 transition-colors" onclick="this.parentElement.remove()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <p class="font-bold">✓ Éxito</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm relative" role="alert">
            <button type="button" class="absolute top-2 right-2 text-red-700 hover:text-red-900 transition-colors" onclick="this.parentElement.remove()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <p class="font-bold">✗ Error</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif
    
    @if (session('info'))
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-md shadow-sm relative" role="alert">
            <button type="button" class="absolute top-2 right-2 text-blue-700 hover:text-blue-900 transition-colors" onclick="this.parentElement.remove()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <p class="font-bold">ⓘ Información</p>
            <p>{{ session('info') }}</p>
        </div>
    @endif
</div>