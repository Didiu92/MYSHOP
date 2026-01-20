<nav class="hidden md:flex space-x-8">
 <a href="{{ route('welcome') }}"
 class="text-silver hover:text-gold transition {{ request()->routeIs('welcome') ? 'text-gold font-semibold' : '' }}">
 Inicio
 </a>
 <a href="{{ route('products.index') }}"
 class="text-silver hover:text-gold transition {{ request()->routeIs('products.*') ? 'text-gold font-semibold' : '' }}">
 Productos
 </a>
 <a href="{{ route('categories.index') }}"
 class="text-silver hover:text-gold transition {{ request()->routeIs('categories.*') ? 'text-gold font-semibold' : '' }}">
 Categorías
 </a>
 <a href="{{ route('offers.index') }}"
 class="text-silver hover:text-gold transition {{ request()->routeIs('offers.*') ? 'text-gold font-semibold' : '' }}">
 Ofertas
 </a>
 <a href="{{ route('contact') }}"
 class="text-silver hover:text-gold transition {{ request()->routeIs('contact') ? 'text-gold font-semibold' : '' }}">
 Contacto
 </a>
 @auth
 <a href="{{ route('dashboard') }}"
 class="text-silver hover:text-gold transition {{ request()->routeIs('dashboard') ? 'text-gold font-semibold' : '' }}">
 Dashboard
 </a>
 @endauth
 @guest
 <a href="{{ route('login') }}"
 class="text-silver hover:text-gold transition {{ request()->routeIs('login') ? 'text-gold font-semibold' : '' }}">
 Login
 </a>
 @endguest
</nav>