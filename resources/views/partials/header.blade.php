<!-- Carrito de Compras -->
<header class="bg-graphite shadow-lg relative border-b border-gold/20">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center space-x-4">
            <a href="{{ route('welcome') }}" class="text-2xl font-bold text-gold hover:text-copper transition">
                    🛍️ Mi Tienda
                </a>
            </div>
            
        <!-- Navegación usando partial -->
        @include('partials.navigation')
            
            <!-- Carrito -->
            @php
                $cart = session('cart', []);
                $totalQuantity = array_sum(array_column($cart, 'quantity'));
            @endphp
            <div class="flex items-center space-x-4">
            <a href="{{ route('cart.index') }}" 
                class="text-silver hover:text-gold transition">
                    🛒 Carrito ( {{ $totalQuantity }} )
            </a>
            
            <!-- User dropdown -->
            @auth
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-silver bg-graphite hover:text-gold focus:outline-none transition">
                        <div class="flex flex-col items-start">
                            <span class="text-sm">{{ Auth::user()->name }}</span>
                            @if(Auth::user()->isAdmin())
                                <span class="mt-1 px-2 py-0.5 text-xs font-semibold rounded bg-gold text-black">Administrador</span>
                            @else
                                <span class="mt-1 px-2 py-0.5 text-xs font-semibold rounded bg-gray-400 text-black">Invitado</span>
                            @endif
                        </div>
                        <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    
                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-graphite ring-1 ring-gold ring-opacity-20 z-50">
                        <div class="py-1">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-silver hover:text-gold hover:bg-ebony">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-silver hover:text-gold hover:bg-ebony">Log Out</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endauth
            </div>
        </div>
    </div>
</header>