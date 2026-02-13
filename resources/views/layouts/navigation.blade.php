@php($user = auth()->user())
<nav x-data="{ open: false }" class="bg-graphite border-b border-gold/20">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo - Centered on mobile, left-aligned on desktop -->
            <div class="flex-1 flex justify-center lg:flex-none lg:justify-start">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('welcome') }}" class="flex items-center gap-3">
                        <img src="{{ asset('images/favicon/favicon.png') }}" alt="Aristocats" class="h-10 w-10 rounded-full border-0" style="clip-path: circle(46% at 50% 50%);" />
                        <span class="hidden lg:inline text-xl font-semibold text-gold">Aristocats</span>
                    </a>
                </div>

            <!-- Navigation Links - Hidden on mobile/tablet, visible on desktop -->
            <div class="hidden space-x-8 lg:-my-px lg:ms-10 lg:flex">
                    <x-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')">
                        {{ __('Tienda') }}
                    </x-nav-link>
                    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                        {{ __('Productos') }}
                    </x-nav-link>
                    <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                        {{ __('Categorías') }}
                    </x-nav-link>
                    <x-nav-link :href="route('offers.index')" :active="request()->routeIs('offers.*')">
                        {{ __('Ofertas') }}
                    </x-nav-link>
                    <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                        {{ __('Contacto') }}
                    </x-nav-link>

                    @if($user?->isWorker())
                        <div x-data="{ open: false }" class="relative flex items-center">
                            <button
                                type="button"
                                @click="open = !open"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-silver hover:text-gold rounded-md transition"
                                style="position: relative; z-index: 99998;"
                                aria-haspopup="menu"
                                :aria-expanded="open.toString()"
                                aria-controls="worker-menu"
                            >
                                Dashboard
                                <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div id="worker-menu" x-show="open" @click.away="open = false" x-cloak role="menu"
                                 style="position: absolute; top: 100%; left: 0; margin-top: 0.5rem; border: 2px solid #FFD700; z-index: 99999;"
                                 class="w-48 rounded-md shadow-lg bg-graphite">
                                <div class="py-1">
                                    <a role="menuitem" href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-silver hover:text-gold hover:bg-ebony">Panel</a>
                                    <a role="menuitem" href="{{ route('admin.products.index') }}" class="block px-4 py-2 text-sm text-silver hover:text-gold hover:bg-ebony">Productos</a>
                                    <a role="menuitem" href="{{ route('admin.categories.index') }}" class="block px-4 py-2 text-sm text-silver hover:text-gold hover:bg-ebony">Categorías</a>
                                    <a role="menuitem" href="{{ route('admin.offers.index') }}" class="block px-4 py-2 text-sm text-silver hover:text-gold hover:bg-ebony">Ofertas</a>
                                    @if($user->isAdmin())
                                        <a role="menuitem" href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-sm text-silver hover:text-gold hover:bg-ebony">Usuarios</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <x-nav-link :href="route('wishlist.index')" :active="request()->routeIs('wishlist.*')">
                        {{ __('❤️ Lista de Deseos') }}
                    </x-nav-link>
                    <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">
                        {{ __('🛒 Carrito') }}
                    </x-nav-link>

                    @guest
                        <x-nav-link :href="route('login')">
                            {{ __('Login / Sign in') }}
                        </x-nav-link>
                    @endguest
                </div>
            </div>

            <!-- Settings Dropdown - Hidden on mobile/tablet, visible on desktop -->
            <div class="hidden lg:flex lg:items-center lg:ms-6">
                @if (Route::has('login'))
                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-silver bg-graphite hover:text-gold focus:outline-none transition ease-in-out duration-150">
                                    <div class="flex flex-col items-start">
                                        <span class="text-sm">{{ Auth::user()->name }}</span>
                                        @php($badge = Auth::user()->isAdmin() ? 'Administrador' : (Auth::user()->isWorkerGuest() ? 'Trabajador' : 'Cliente'))
                                        <span class="mt-1 px-2 py-0.5 text-xs font-semibold rounded {{ Auth::user()->isAdmin() ? 'bg-gold text-black' : (Auth::user()->isWorkerGuest() ? 'bg-copper text-black' : 'bg-graphite text-silver border border-gold/30') }}">{{ $badge }}</span>
                                    </div>

                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Perfil') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Cerrar Sesión') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @else
                        <a href="{{ route('login') }}" class="text-silver hover:text-gold px-3 py-2 rounded-md text-sm font-medium">
                            {{ __('Iniciar Sesión') }}
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ms-4 text-silver hover:text-gold px-3 py-2 rounded-md text-sm font-medium">
                                {{ __('Registrarse') }}
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

            <!-- Hamburger Menu - Shown on mobile/tablet, hidden on desktop -->
            <div class="-me-2 flex items-center lg:hidden">
                <button
                    type="button"
                    @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-silver hover:text-gold hover:bg-graphite focus:outline-none focus:bg-graphite focus:text-gold transition duration-150 ease-in-out"
                    :aria-expanded="open.toString()"
                    aria-controls="app-mobile-menu"
                    aria-label="Alternar menu de navegacion"
                >
                    <span class="sr-only">Menu principal</span>
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu - Shown on mobile/tablet, hidden on desktop -->
    <div id="app-mobile-menu" :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden" aria-label="Menu principal">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')">
                {{ __('Tienda') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                {{ __('Productos') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                {{ __('Categorías') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('offers.index')" :active="request()->routeIs('offers.*')">
                {{ __('Ofertas') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                {{ __('Contacto') }}
            </x-responsive-nav-link>

            @if($user?->isWorker())
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                    {{ __('Productos (Admin)') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                    {{ __('Categorías (Admin)') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.offers.index')" :active="request()->routeIs('admin.offers.*')">
                    {{ __('Ofertas (Admin)') }}
                </x-responsive-nav-link>
                @if($user->isAdmin())
                    <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                        {{ __('Usuarios') }}
                    </x-responsive-nav-link>
                @endif
            @endif

            <x-responsive-nav-link :href="route('wishlist.index')" :active="request()->routeIs('wishlist.*')">
                {{ __('❤️ Wishlist') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">
                {{ __('🛒 Carrito') }}
            </x-responsive-nav-link>

            @guest
                <x-responsive-nav-link :href="route('login')">
                    {{ __('Login / Sign in') }}
                </x-responsive-nav-link>
            @endguest
        </div>

        <!-- Responsive Settings Options -->
        @if(auth()->check())
        <div class="pt-4 pb-1 border-t border-gold/20">
            <div class="px-4">
                <div class="font-medium text-base text-gold">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-silver">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @else
        <div class="pt-4 pb-1 border-t border-gold/20">
            <div class="px-4 space-y-2">
                <a href="{{ route('login') }}" class="block text-silver hover:text-gold px-3 py-2 rounded-md text-base font-medium">
                    {{ __('Iniciar Sesión') }}
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="block text-silver hover:text-gold px-3 py-2 rounded-md text-base font-medium">
                        {{ __('Registrarse') }}
                    </a>
                @endif
            </div>
        </div>
        @endif
    </div>
</nav>