@extends('layouts.public')
@section('title', 'Contacto - Mi Tienda')
@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gold mb-4">Contacta con Nosotros</h1>
            <p class="text-silver">Estamos aquí para ayudarte. Envíanos un mensaje y te responderemos pronto.</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg mb-6 shadow-sm">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="card p-8">
            <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Nombre --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-silver mb-2">Nombre *</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="w-full px-4 py-3 bg-ebony border rounded-lg focus:ring-2 focus:ring-gold focus:border-transparent transition @error('name') border-red-500 @else border-gray-600 @enderror text-silver"
                           placeholder="Tu nombre completo"
                           required>
                    @error('name')
                        <p class="mt-2 text-sm text-red-500 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-silver mb-2">Correo Electrónico *</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           class="w-full px-4 py-3 bg-ebony border rounded-lg focus:ring-2 focus:ring-gold focus:border-transparent transition @error('email') border-red-500 @else border-gray-600 @enderror text-silver"
                           placeholder="tu@email.com"
                           required>
                    @error('email')
                        <p class="mt-2 text-sm text-red-500 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Asunto --}}
                <div>
                    <label for="subject" class="block text-sm font-medium text-silver mb-2">Asunto *</label>
                    <input type="text" 
                           id="subject" 
                           name="subject" 
                           value="{{ old('subject') }}"
                           class="w-full px-4 py-3 bg-ebony border rounded-lg focus:ring-2 focus:ring-gold focus:border-transparent transition @error('subject') border-red-500 @else border-gray-600 @enderror text-silver"
                           placeholder="¿En qué podemos ayudarte?"
                           required>
                    @error('subject')
                        <p class="mt-2 text-sm text-red-500 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Mensaje --}}
                <div>
                    <label for="message" class="block text-sm font-medium text-silver mb-2">Mensaje *</label>
                    <textarea id="message" 
                              name="message" 
                              rows="6"
                              class="w-full px-4 py-3 bg-ebony border rounded-lg focus:ring-2 focus:ring-gold focus:border-transparent transition @error('message') border-red-500 @else border-gray-600 @enderror text-silver resize-none"
                              placeholder="Escribe tu mensaje aquí (mínimo 10 caracteres)..."
                              required>{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-2 text-sm text-red-500 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">Máximo 1000 caracteres</p>
                </div>

                {{-- Botones --}}
                <div class="flex gap-4 pt-4">
                    <button type="submit" class="btn-primary flex-1">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Enviar Mensaje
                    </button>
                    <a href="{{ route('welcome') }}" class="px-6 py-3 bg-gray-600 text-silver rounded-lg hover:bg-gray-500 transition text-center">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

        {{-- Información adicional --}}
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center p-4">
                <div class="text-gold text-3xl mb-2">📧</div>
                <h3 class="text-silver font-semibold mb-1">Email</h3>
                <p class="text-gray-400 text-sm">info@mitienda.com</p>
            </div>
            <div class="text-center p-4">
                <div class="text-gold text-3xl mb-2">📞</div>
                <h3 class="text-silver font-semibold mb-1">Teléfono</h3>
                <p class="text-gray-400 text-sm">+34 123 456 789</p>
            </div>
            <div class="text-center p-4">
                <div class="text-gold text-3xl mb-2">🕒</div>
                <h3 class="text-silver font-semibold mb-1">Horario</h3>
                <p class="text-gray-400 text-sm">Lun - Vie: 9:00 - 18:00</p>
            </div>
        </div>
    </div>
</div>
@endsection