@extends('layouts.public')
@section('title', 'Contacto - Mi Tienda')
@section('content')
 <div class="container mx-auto px-6 py-8">
 <div class="max-w-2xl mx-auto">
 <div class="mb-8 text-center">
 <h1 class="text-3xl font-bold text-gold mb-4">Contacta con
Nosotros</h1>
 <p class="text-silver">Estamos aquí para ayudarte. Envíanos un
mensaje.</p>
 </div>
 <div class="card p-8 flex flex-col items-center justify-center">
 <svg class="w-20 h-20 text-gold mb-4 animate-bounce"
fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 48 48">
 <circle cx="24" cy="24" r="22" stroke="currentColor" strokewidth="4" fill="#e0e7ff"/>
 <path d="M16 32l8-8 8 8" stroke="currentColor" strokewidth="3" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
 <path d="M24 16v8" stroke="currentColor" stroke-width="3"
stroke-linecap="round" stroke-linejoin="round" fill="none"/>
 </svg>
 <h2 class="text-2xl font-bold text-gold mb-2">¡En
Construcción!</h2>
 <p class="text-silver/70 mb-4">Estamos trabajando para traerte esta
funcionalidad muy pronto.</p>
 <a href="{{ route('welcome') }}" class="btn-primary inline-block mt-2">
 Volver al inicio
 </a>
 </div>
 </div>
 </div>
@endsection