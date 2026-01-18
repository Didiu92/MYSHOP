{{-- Sistema de Notificaciones Flash --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm" role="alert">
            <p class="font-bold">✓ Éxito</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm" role="alert">
            <p class="font-bold">✗ Error</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif
    
    @if (session('info'))
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-md shadow-sm" role="alert">
            <p class="font-bold">ⓘ Información</p>
            <p>{{ session('info') }}</p>
        </div>
    @endif
</div>