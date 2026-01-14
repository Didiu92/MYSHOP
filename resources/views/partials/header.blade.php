<!-- Header con navegación -->
<header class="bg-white shadow-lg relative">
 <div class="container mx-auto px-6 py-4">
 <div class="flex items-center justify-between">
 <!-- Logo -->
 <div class="flex items-center space-x-4">
 <a href="{{ route('welcome') }}" class="text-2xl font-bold textprimary-600">
 🛍 Mi Tienda
 </a>
 </div>
 <!-- Navegación usando partial -->
 @include('partials.navigation')
 <!-- Carrito -->
 <div class="flex items-center space-x-4">
 <a href="{{ route('cart.index') }}"
 class="text-gray-700 hover:text-primary-600 transition">
 🛒 Carrito (0)
 </a>
 </div>
 </div>
 </div>
 </header>
