<nav x-data="{ isMobileMenuOpen: false }" class="relative bg-gray-600 dark:bg-gray-800">
    <div class="container px-6 py-2 mx-auto">
        <div class="lg:flex lg:items-center lg:justify-between">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a class="text-gray-100 font-bold dark:text-white" href="{{ route('home') }}">
                        {{ config('app.name', 'Demo') }}
                    </a>


                </div>
                <!-- Mobile menu button -->
                <div class="flex lg:hidden" x-cloak>
                    <button x-show="!isMobileMenuOpen"
                        class="lg:hidden rounded-md mx-5 focus:outline-none focus:shadow-outline-purple"
                        @click="toggleTheme" aria-label="Toggle color mode">
                        <template x-if="!dark">
                            <svg class="w-5 h-5" aria-hidden="true" fill="gray" viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                            </svg>
                        </template>
                        <template x-if="dark">
                            <svg class="w-5 h-5" aria-hidden="true" fill="white" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </template>
                    </button>
                    <button @click="isMobileMenuOpen = !isMobileMenuOpen" type="button"
                        class="text-gray-500 dark:text-gray-200 hover:text-gray-600 dark:hover:text-gray-400 focus:outline-none focus:text-gray-600 dark:focus:text-gray-400"
                        aria-label="toggle menu">
                        <svg x-show="!isMobileMenuOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
                            fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16" />
                        </svg>

                        <svg x-show="isMobileMenuOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                            viewBox="0 0 24 24" stroke="white" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>


            <!-- Mobile Menu open: "block", Menu closed: "hidden" -->
            <div x-cloak :class="[isMobileMenuOpen ? 'translate-x-0 opacity-100 ' : 'opacity-0 -translate-x-full']"
                class="absolute inset-x-0 z-20 w-full px-6 py-4  bg-gray-600 dark:bg-gray-800 lg:mt-0 lg:p-0 lg:top-0 lg:relative lg:bg-transparent lg:w-auto lg:opacity-100 lg:translate-x-0 lg:flex lg:items-center">

                @if (Auth::user())
                    <div class="flex flex-col lg:flex-row lg:items-center lg:mx-8">
                         <x-nav-link class="mx-1" :href="route('home')" :active="request()->routeIs('home')">
                            Home
                        </x-nav-link>
                        <a class="mx-1 relative" href="{{ route('cart') }}">
                            <i class="fa fa-cart-shopping text-white"></i>
                            <span class="cart-count absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2 bg-red-500 text-white rounded-full text-xs px-1 py-0">
                                {{Auth::user()->cart->count()}}
                            </span>
                        </a>

                        {{--                        <x-nav-link class="mx-1" :href="route('about')" :active="request()->routeIs('about')">--}}
{{--                            About Us--}}
{{--                        </x-nav-link> --}}
                    </div>
                    <div class="flex items-center lg:mt-0">
                        <div x-data="{ isProfileMenuOpen: false }" class="relative w-full">

                            <div class="flex flex-col mt-5 lg:mt-0">
                                <button type="button" @click="isProfileMenuOpen = !isProfileMenuOpen"
                                    class="flex items-center focus:outline-none relative z-10  p-0 md:p-2 transition-colors duration-300 transform rounded-lg"
                                    aria-label="toggle profile dropdown">
                                    <div class="w-8 h-8 overflow-hidden border-2 border-gray-400 rounded-full">
                                        <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=334&q=80"
                                            class="object-cover w-full h-full" alt="avatar">
                                    </div>

                                    <h3 class="mx-2 text-white dark:text-gray-200 lg:hidden">
                                        {{ Auth::user()->name }}
                                    </h3>
                                </button>
                                <form class="md:hidden" method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <input type="submit"
                                        class="cursor-pointer block mt-8 px-4 bg-red-500 py-2 text-sm text-white text-center rounded-md w-full font-bold transition-colors duration-300 transform hover:bg-gray-100 dark:hover:bg-red-700"
                                        value="{{ __('Log Out') }}">
                                </form>
                            </div>
                            <div x-show="isProfileMenuOpen" x-cloak @click.away="isProfileMenuOpen = false"
                                class="absolute right-0 z-20 w-48 mt-3 overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800 hidden lg:block">

                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-3 text-sm text-gray-800 transition-colors duration-300 transform border-b dark:text-gray-200 dark:border-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <span class="text-gray-600 dark:text-gray-400">{{ Auth::user()->name }}</span></a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <input type="submit"
                                        class="block w-full text-start px-4 py-2 text-sm dark:text-red-500 font-bold transition-colors duration-300 transform hover:bg-gray-100 dark:hover:bg-gray-700"
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

                <button class="hidden lg:block rounded-md ms-5 focus:outline-none focus:shadow-outline-purple"
                    @click="toggleTheme" aria-label="Toggle color mode">
                    <template x-if="!dark">
                        <svg class="w-6 h-6" aria-hidden="true" fill="gray" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                    </template>
                    <template x-if="dark">
                        <svg class="w-6 h-6" aria-hidden="true" fill="white" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </template>
                </button>
            </div>
        </div>
    </div>
</nav>
