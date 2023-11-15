<nav x-data="{ isMobileMenuOpen: false }" class="relative bg-gray-200 shadow-md">
    <div class="container px-2 mx-auto">
        <div class="lg:flex lg:items-center lg:justify-between">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('home') }}">
                        <img src="/images/logo.png" class="w-28 h-auto my-2" />
                    </a>
                </div>
                <!-- Mobile menu button -->
                <div class="flex lg:hidden items-center gap-2" x-cloak>
                    @if (Auth::user())
                        @if(!Route::is('payment.direct-checkout') && !Route::is('payment.showstatus'))
                            <button @click="isCartShown=true" x-show="!isMobileMenuOpen" class="flex items-center relative">
                                <i class="fa fa-cart-shopping text-purple-500"></i>
                                <span class="cart-count absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2 bg-red-500 text-white rounded-full text-xs px-1 py-0">
                                    {{Auth::user()->cart->count()}}
                                </span>
                            </button>
                        @endif
                        @if(Route::is('payment.direct-checkout'))
                            <a x-show="!isMobileMenuOpen" href="{{route('home')}}">
                                <i class="fa fa-home text-purple-500"></i>
                            </a>
                        @endif
                    @endif

                    <button @click="isMobileMenuOpen = !isMobileMenuOpen" type="button"
                            class="text-purple-500 hover:text-purple-700 focus:outline-none focus:text-purple-700"
                            aria-label="toggle menu">
                        <svg x-show="!isMobileMenuOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
                             fill="none" viewBox="0 0 24 24" stroke="purple" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16" />
                        </svg>

                        <svg x-show="isMobileMenuOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                             viewBox="0 0 24 24" stroke="purple" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>


            <!-- Mobile Menu open: "block", Menu closed: "hidden" -->
            <div x-cloak :class="[isMobileMenuOpen ? 'translate-x-0 opacity-100 ' : 'opacity-0 -translate-x-full']"
                 class="z-10 absolute gap-2 inset-x-0 w-full px-6 py-4 bg-gray-200 lg:mt-0 lg:p-0 lg:top-0 lg:relative lg:bg-transparent lg:w-auto lg:opacity-100 lg:translate-x-0 lg:flex lg:items-center">
                @if (Auth::user())
                    @if(!Route::is('payment.direct-checkout') && !Route::is('payment.showstatus'))
                        <button @click="isCartShown=true" x-show="!isMobileMenuOpen" class="flex items-center relative">
                            <i class="fa fa-cart-shopping text-purple-800"></i>
                            <span class="cart-count absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2 text-white rounded-full text-xs px-1 py-0">
                                {{Auth::user()->cart->count()}}
                            </span>
                        </button>
                    @endif
                    @if(Route::is('payment.direct-checkout'))
                        <a x-show="!isMobileMenuOpen" href="{{route('home')}}">
                            <i class="fa fa-home text-purple-800"></i>
                        </a>
                    @endif

                    <div class="flex items-center lg:mt-0">
                        <div x-data="{ isProfileMenuOpen: false }" class="relative w-full">

                            <div class="flex flex-col mt-5 lg:mt-0">
                                <button type="button" @click="isProfileMenuOpen = !isProfileMenuOpen"
                                        class="flex items-center focus:outline-none relative p-0 md:p-2 transition-colors duration-300 transform rounded-lg"
                                        aria-label="toggle profile dropdown">
                                    <div class="w-8 h-8 overflow-hidden border border-white rounded-full">
                                        <img src="/images/mascot.png"
                                             class="object-cover w-full h-full" alt="avatar">
                                    </div>

                                    <span
                                        class="block px-1 text-sm text-gray-800 transition-colors duration-300 transform border-b">
                                     <span class="text-gray-600 text-lg font-bold">{{ Auth::user()->name }}</span></span>

                                </button>
                                <form class="md:hidden" method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <input type="submit"
                                           class="cursor-pointer block mt-8 px-4 bg-gray-300 py-2 text-sm  text-center rounded-sm w-full font-bold transition-colors duration-300 transform"
                                           value="{{ __('Log Out') }}">
                                </form>
                            </div>
                            <div x-show="isProfileMenuOpen" x-cloak @click.away="isProfileMenuOpen = false"
                                 class="absolute right-0 w-48 mt-3 overflow-hidden rounded-lg shadow-xl z-50  bg-gray-300 hidden lg:block">

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <input type="submit"
                                           class="cursor-pointer block w-full text-start px-4 py-2 text-sm  font-bold transition-colors duration-300 transform hover:bg-gray-100 dark:hover:bg-gray-700"
                                           value="{{ __('Log Out') }}">
                                </form>
                            </div>
                        </div>

                    </div>


                @else
                    <div class="flex flex-col lg:flex-row">
                        <x-nav-link class="" :href="route('login')">
                            Login
                        </x-nav-link>
                        <x-nav-link class="me-7" :href="route('register')">
                            Signup
                        </x-nav-link>
                    </div>
                @endif

            </div>
        </div>
    </div>
</nav>
