@php($user = auth()->user())
<nav class="hidden md:flex space-x-8 items-center">
	<a href="{{ route('welcome') }}"
	   class="text-silver hover:text-gold transition {{ request()->routeIs('welcome') ? 'text-gold font-semibold' : '' }}">
		Tienda
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

	@if($user?->isWorker())
		<div x-data="{ open: false }" class="relative">
			<button @click="open = !open"
					class="inline-flex items-center px-3 py-2 text-silver hover:text-gold transition rounded-md">
				Dashboard
				<svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
				</svg>
			</button>
			<div x-show="open" @click.away="open = false" x-cloak
				 style="border: 2px solid #FFD700; z-index: 99999;"
				 class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-graphite">
				<div class="py-1">
					<a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-silver hover:text-gold hover:bg-ebony">Panel</a>
					<a href="{{ route('admin.products.index') }}" class="block px-4 py-2 text-sm text-silver hover:text-gold hover:bg-ebony">Productos</a>
					<a href="{{ route('admin.categories.index') }}" class="block px-4 py-2 text-sm text-silver hover:text-gold hover:bg-ebony">Categorías</a>
					<a href="{{ route('admin.offers.index') }}" class="block px-4 py-2 text-sm text-silver hover:text-gold hover:bg-ebony">Ofertas</a>
					@if($user->isAdmin())
						<a href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-sm text-silver hover:text-gold hover:bg-ebony">Usuarios</a>
					@endif
				</div>
			</div>
		</div>
	@endif

	<a href="{{ route('wishlist.index') }}"
	   class="text-silver hover:text-gold transition {{ request()->routeIs('wishlist.*') ? 'text-gold font-semibold' : '' }}">
		❤️ Wishlist
	</a>
	<a href="{{ route('cart.index') }}"
	   class="text-silver hover:text-gold transition {{ request()->routeIs('cart.*') ? 'text-gold font-semibold' : '' }}">
		🛒 Carrito
	</a>

	@guest
		<a href="{{ route('login') }}"
		   class="text-silver hover:text-gold transition {{ request()->routeIs('login') ? 'text-gold font-semibold' : '' }}">
			Login / Sign in
		</a>
	@endguest
</nav>