<nav x-data="{ isMobileMenuOpen: false }" class="relative bg-white shadow dark:bg-gray-800">
    <div class="container px-6 py-2 mx-auto">
        <div class="lg:flex lg:items-center lg:justify-between">
            <div class="flex items-center justify-between">
                <a class="text-white" href="{{ route('home') }}">
                    {{ config('app.name', 'Demo') }}
                </a>

                <!-- Mobile menu button -->
                <div class="flex lg:hidden">
                    <button x-cloak @click="isMobileMenuOpen = !isMobileMenuOpen" type="button"
                        class="text-gray-500 dark:text-gray-200 hover:text-gray-600 dark:hover:text-gray-400 focus:outline-none focus:text-gray-600 dark:focus:text-gray-400"
                        aria-label="toggle menu">
                        <svg x-show="!isMobileMenuOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16" />
                        </svg>

                        <svg x-show="isMobileMenuOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu open: "block", Menu closed: "hidden" -->
            <div x-cloak :class="[isMobileMenuOpen ? 'translate-x-0 opacity-100 ' : 'opacity-0 -translate-x-full']"
                class="absolute inset-x-0 z-20 w-full px-6 py-4 transition-all duration-300 ease-in-out bg-white dark:bg-gray-800 lg:mt-0 lg:p-0 lg:top-0 lg:relative lg:bg-transparent lg:w-auto lg:opacity-100 lg:translate-x-0 lg:flex lg:items-center">
                <div class="flex flex-col -mx-6 lg:flex-row lg:items-center lg:mx-8">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        Home
                    </x-nav-link>
                    <x-nav-link :href="route('categories')" :active="request()->routeIs('categories')">
                        Categories
                    </x-nav-link>
                    <x-nav-link :href="route('about')" :active="request()->routeIs('about')">
                        About Us
                    </x-nav-link>
                </div>

                <div class="flex items-center mt-4 lg:mt-0">
                    <div x-data="{ isProfileMenuOpen: false }" class="relative">
                        <button type="button" @click="isProfileMenuOpen = !isProfileMenuOpen"
                            class="flex items-center focus:outline-none relative z-10  p-2 transition-colors duration-300 transform rounded-lg"
                            aria-label="toggle profile dropdown">
                            <div class="w-8 h-8 overflow-hidden border-2 border-gray-400 rounded-full">
                                <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=334&q=80"
                                    class="object-cover w-full h-full" alt="avatar">
                            </div>

                            <h3 class="mx-2 text-gray-700 dark:text-gray-200 lg:hidden"> {{ __('Profile') }}</h3>
                        </button>
                        <div x-show="isProfileMenuOpen" @click.away="isProfileMenuOpen = false"
                            class="absolute right-0 z-20 w-48 mt-3 overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">

                            <a href="#"
                                class="block px-4 py-3 text-sm text-gray-800 transition-colors duration-300 transform border-b dark:text-gray-200 dark:border-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <span class="text-gray-600 dark:text-gray-400"> {{ Auth::user()->name }}</span></a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <input type="submit"
                                    class="block w-full text-start px-4 py-2 text-sm dark:text-red-500 font-bold transition-colors duration-300 transform hover:bg-gray-100 dark:hover:bg-gray-700"
                                    value="{{ __('Log Out') }}">
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</nav>
