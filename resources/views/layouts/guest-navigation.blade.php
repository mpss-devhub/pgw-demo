<nav x-data="{ isMobileMenuOpen: false }" class="relative bg-transparent z-40">
    <div class="container px-6 py-2 mx-auto">
        <div class="lg:flex lg:items-center lg:justify-between">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a  href="{{ route('home') }}">
                    <img src="/images/logo.png" class="w-28 h-auto my-2"/>
                    </a>
                </div>
                <!-- Mobile menu button -->
                <div class="flex lg:hidden items-center" x-cloak>
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
                class="absolute inset-x-0 w-full px-6 py-4 lg:mt-0 lg:p-0 lg:top-0 lg:relative lg:bg-transparent lg:w-auto lg:opacity-100 lg:translate-x-0 lg:flex lg:items-center">
                    <div class="flex flex-col lg:flex-row">
                        <x-nav-link class="font-bold" :href="route('login')">
                            Login
                        </x-nav-link>
                        <x-nav-link class="me-7 font-bold" :href="route('register')">
                            Signup
                        </x-nav-link>
                    </div>
            </div>
        </div>
    </div>
</nav>
