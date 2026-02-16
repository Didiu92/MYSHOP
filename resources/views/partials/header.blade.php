<!-- Carrito de Compras -->
<header x-data="{ mobileMenuOpen: false }" class="bg-graphite shadow-lg relative border-b border-gold/20">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between gap-4">
            <!-- Hamburger Menu Button - Visible on mobile/tablet, hidden on desktop -->
            <button
                type="button"
                @click="mobileMenuOpen = !mobileMenuOpen"
                class="lg:hidden flex-shrink-0 inline-flex items-center justify-center p-2 rounded-md text-silver hover:text-gold transition"
                :aria-expanded="mobileMenuOpen.toString()"
                aria-controls="site-mobile-menu"
                aria-label="Alternar menu de navegacion"
            >
                <span class="sr-only" x-text="mobileMenuOpen ? 'Cerrar menu' : 'Abrir menu'"></span>
                <svg class="h-6 w-6" :class="{'hidden': mobileMenuOpen}" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg class="h-6 w-6" :class="{'hidden': !mobileMenuOpen}" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Logo + Title - Centered on mobile, left on desktop -->
            <div class="flex-1 flex justify-center lg:flex-none">
                <a href="{{ route('welcome') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/favicon/favicon.png') }}" alt="Aristocats" class="h-20 w-20 rounded-full border-0" style="clip-path: circle(46% at 50% 50%);">
                    <span class="text-2xl font-bold text-gold group-hover:text-copper transition">Aristocats</span>
                </a>
            </div>
            
            <!-- Navegación horizontal - Hidden on mobile/tablet, visible on desktop -->
            @include('partials.navigation')

            <form id="currency-form-desktop" method="POST" action="{{ route('currency.set') }}" class="hidden lg:flex items-center" style="display: flex !important;">
                @csrf
                <label for="currency" class="sr-only">Moneda</label>
                <select
                    id="currency"
                    name="currency"
                    class="bg-ebony border border-gold/30 text-silver rounded-md px-2 py-1 text-sm focus:ring-2 focus:ring-gold focus:border-transparent"
                >
                    @foreach($currencyOptions as $code => $label)
                        <option value="{{ $code }}" {{ $currency === $code ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </form>
            <script>
                document.getElementById('currency').addEventListener('change', function() {
                    document.getElementById('currency-form-desktop').submit();
                });
            </script>
            
            <!-- User dropdown -->
            @auth
                <div x-data="{ open: false }" class="relative flex-shrink-0">
                    <button
                        type="button"
                        @click="open = !open"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-silver bg-graphite hover:text-gold focus:outline-none transition"
                        aria-haspopup="menu"
                        :aria-expanded="open.toString()"
                        aria-controls="user-menu"
                    >
                        <div class="flex flex-col items-start">
                            <span class="text-sm">{{ Auth::user()->name }}</span>
                            @php($badge = Auth::user()->isAdmin() ? 'Administrador' : (Auth::user()->isWorkerGuest() ? 'Trabajador' : 'Cliente'))
                            <span class="mt-1 px-2 py-0.5 text-xs font-semibold rounded {{ Auth::user()->isAdmin() ? 'bg-gold text-black' : (Auth::user()->isWorkerGuest() ? 'bg-copper text-black' : 'bg-gray-400 text-black') }}">{{ $badge }}</span>
                        </div>
                        <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    
                    <div id="user-menu" x-show="open" @click.away="open = false" x-transition role="menu" class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-graphite ring-1 ring-gold ring-opacity-20 z-50">
                        <div class="py-1">
                            <a role="menuitem" href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-silver hover:text-gold hover:bg-ebony">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" role="menuitem" class="block w-full text-left px-4 py-2 text-sm text-silver hover:text-gold hover:bg-ebony">Log Out</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
        
        <!-- Mobile Menu - Shown when hamburger is clicked -->
        <nav id="site-mobile-menu" x-show="mobileMenuOpen" x-transition class="lg:hidden mt-4 pb-4 border-t border-gold/20 pt-4 space-y-2" role="navigation" aria-label="Menu principal" aria-hidden="false">
            @php($user = auth()->user())
            <a href="{{ route('welcome') }}" class="block px-4 py-2 rounded text-silver hover:text-gold hover:bg-ebony transition {{ request()->routeIs('welcome') ? 'text-gold font-semibold bg-ebony' : '' }}">
                Tienda
            </a>
            <a href="{{ route('products.index') }}" class="block px-4 py-2 rounded text-silver hover:text-gold hover:bg-ebony transition {{ request()->routeIs('products.*') ? 'text-gold font-semibold bg-ebony' : '' }}">
                Productos
            </a>
            <a href="{{ route('categories.index') }}" class="block px-4 py-2 rounded text-silver hover:text-gold hover:bg-ebony transition {{ request()->routeIs('categories.*') ? 'text-gold font-semibold bg-ebony' : '' }}">
                Categorías
            </a>
            <a href="{{ route('offers.index') }}" class="block px-4 py-2 rounded text-silver hover:text-gold hover:bg-ebony transition {{ request()->routeIs('offers.*') ? 'text-gold font-semibold bg-ebony' : '' }}">
                Ofertas
            </a>
            <a href="{{ route('contact') }}" class="block px-4 py-2 rounded text-silver hover:text-gold hover:bg-ebony transition {{ request()->routeIs('contact') ? 'text-gold font-semibold bg-ebony' : '' }}">
                Contacto
            </a>
            
            @if($user?->isWorker())
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded text-silver hover:text-gold hover:bg-ebony transition {{ request()->routeIs('admin.dashboard') ? 'text-gold font-semibold bg-ebony' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}" class="block px-4 py-2 rounded text-silver hover:text-gold hover:bg-ebony transition {{ request()->routeIs('admin.products.*') ? 'text-gold font-semibold bg-ebony' : '' }}">
                    Productos (Admin)
                </a>
                <a href="{{ route('admin.categories.index') }}" class="block px-4 py-2 rounded text-silver hover:text-gold hover:bg-ebony transition {{ request()->routeIs('admin.categories.*') ? 'text-gold font-semibold bg-ebony' : '' }}">
                    Categorías (Admin)
                </a>
                <a href="{{ route('admin.offers.index') }}" class="block px-4 py-2 rounded text-silver hover:text-gold hover:bg-ebony transition {{ request()->routeIs('admin.offers.*') ? 'text-gold font-semibold bg-ebony' : '' }}">
                    Ofertas (Admin)
                </a>
                @if($user->isAdmin())
                    <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 rounded text-silver hover:text-gold hover:bg-ebony transition {{ request()->routeIs('admin.users.*') ? 'text-gold font-semibold bg-ebony' : '' }}">
                        Usuarios
                    </a>
                @endif
            @endif
            
            <a href="{{ route('wishlist.index') }}" class="block px-4 py-2 rounded text-silver hover:text-gold hover:bg-ebony transition {{ request()->routeIs('wishlist.*') ? 'text-gold font-semibold bg-ebony' : '' }}">
                ❤️ Wishlist
            </a>
            <a href="{{ route('cart.index') }}" class="block px-4 py-2 rounded text-silver hover:text-gold hover:bg-ebony transition {{ request()->routeIs('cart.*') ? 'text-gold font-semibold bg-ebony' : '' }}">
                🛒 Carrito
            </a>

            <form id="currency-form-mobile" method="POST" action="{{ route('currency.set') }}" class="pt-2">
                @csrf
                <label for="currency-mobile" class="sr-only">Moneda</label>
                <select
                    id="currency-mobile"
                    name="currency"
                    class="w-full bg-ebony border border-gold/30 text-silver rounded-md px-2 py-2 text-sm focus:ring-2 focus:ring-gold focus:border-transparent"
                >
                    @foreach($currencyOptions as $code => $label)
                        <option value="{{ $code }}" {{ $currency === $code ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </form>
            <script>
                document.getElementById('currency-mobile').addEventListener('change', function() {
                    document.getElementById('currency-form-mobile').submit();
                });
            </script>
            
            @guest
                <a href="{{ route('login') }}" class="block px-4 py-2 rounded text-silver hover:text-gold hover:bg-ebony transition {{ request()->routeIs('login') ? 'text-gold font-semibold bg-ebony' : '' }}">
                    Login / Sign in
                </a>
            @endguest
        </nav>
    </div>
</header>