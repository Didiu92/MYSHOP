<nav class="hidden md:flex space-x-8">
 <a href="{{ route('welcome') }}"
 class="text-gray-700 hover:text-primary-600 transition {{ request()->routeIs('welcome') ? 'text-primary-600 font-semibold' : '' }}">
 Inicio
 </a>
 <a href="{{ route('products.index') }}"
 class="text-gray-700 hover:text-primary-600 transition {{ request()->routeIs('products.*') ? 'text-primary-600 font-semibold' : '' }}">
 Productos
 </a>
 <a href="{{ route('categories.index') }}"
 class="text-gray-700 hover:text-primary-600 transition {{ request()->routeIs('categories.*') ? 'text-primary-600 font-semibold' : '' }}">
 Categorías
 </a>
 <a href="{{ route('offers.index') }}"
 class="text-gray-700 hover:text-primary-600 transition {{ request()->routeIs('offers.*') ? 'text-primary-600 font-semibold' : '' }}">
 Ofertas
 </a>
 <a href="{{ route('contact') }}"
 class="text-gray-700 hover:text-primary-600 transition {{ request()->routeIs('contact') ? 'text-primary-600 font-semibold' : '' }}">
 Contacto
 </a>
 @auth
 <a href="{{ route('dashboard') }}"
 class="text-gray-700 hover:text-primary-600 transition {{ request()->routeIs('dashboard') ? 'text-primary-600 font-semibold' : '' }}">
 Dashboard
 </a>
 @endauth
 @guest
 <a href="{{ route('login') }}"
 class="text-gray-700 hover:text-primary-600 transition {{ request()->routeIs('login')
 Login
 </a>
 @endguest
</nav>