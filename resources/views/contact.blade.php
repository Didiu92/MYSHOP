@extends('layouts.app')
@section('title', 'Contacto - Mi Tienda')
@section('content')
 <div class="container mx-auto px-6 py-8">
 <div class="max-w-2xl mx-auto">
 <div class="mb-8 text-center">
 <h1 class="text-3xl font-bold text-gray-900 mb-4">Contacta con
Nosotros</h1>
 <p class="text-gray-600">Estamos aquí para ayudarte. Envíanos un
mensaje.</p>
 </div>
 <div class="bg-white rounded-lg shadow-lg p-8 flex flex-col itemscenter justify-center">
 <svg class="w-20 h-20 text-primary-600 mb-4 animate-bounce"
fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 48 48">
 <circle cx="24" cy="24" r="22" stroke="currentColor" strokewidth="4" fill="#e0e7ff"/>
 <path d="M16 32l8-8 8 8" stroke="currentColor" strokewidth="3" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
 <path d="M24 16v8" stroke="currentColor" stroke-width="3"
stroke-linecap="round" stroke-linejoin="round" fill="none"/>
 </svg>
 <h2 class="text-2xl font-bold text-gray-800 mb-2">¡En
Construcción!</h2>
 <p class="text-gray-500 mb-4">Estamos trabajando para traerte esta
funcionalidad muy pronto.</p>
 <a href="{{ route('welcome') }}" class="inline-block mt-2 px-6 py2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
 Volver al inicio
 </a>
 </div>
 </div>
 </div>
@endsection