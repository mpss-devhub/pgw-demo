<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        function setDarkModePreference() {
            const prefersDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const darkMode = localStorage.getItem('dark');
            if (darkMode !== null) {
                return JSON.parse(darkMode);
            } else {
                return prefersDarkMode;
            }
        }

        function setDarkMode(darkMode) {
            localStorage.setItem('dark', darkMode);
            document.documentElement.classList.toggle('dark', darkMode);
        }

        // Apply dark mode immediately
        const darkModePreference = setDarkModePreference();
        setDarkMode(darkModePreference);
    </script>
</head>

<body class="font-sans text-gray-900 antialiased  bg-gray-100 dark:bg-gray-700" :class="{ 'dark': dark }" x-data="{
    dark: setDarkModePreference(),
    toggleTheme: function() {
        this.dark = !this.dark;
        localStorage.setItem('dark', this.dark);
        document.documentElement.classList.toggle('dark', this.dark)
    }
}"
    x-init="setDarkMode(dark)">
    <div>
{{--        <div class="flex justify-end px-6 mx-auto py-5">--}}
{{--            <button class="rounded-md  focus:outline-none focus:shadow-outline-purple" @click="toggleTheme"--}}
{{--                aria-label="Toggle color mode">--}}
{{--                <template x-if="!dark">--}}
{{--                    <svg class="w-6 h-6" aria-hidden="true" fill="gray" viewBox="0 0 20 20">--}}
{{--                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>--}}
{{--                    </svg>--}}
{{--                </template>--}}
{{--                <template x-if="dark">--}}
{{--                    <svg class="w-6 h-6" aria-hidden="true" fill="white" viewBox="0 0 20 20">--}}
{{--                        <path fill-rule="evenodd"--}}
{{--                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"--}}
{{--                            clip-rule="evenodd"></path>--}}
{{--                    </svg>--}}
{{--                </template>--}}
{{--            </button>--}}
{{--        </div>--}}
        <div class="min-h-screen flex flex-col content-center justify-start lg:justify-center pt-6 sm:pt-0 p-3"
             style="background-image: url('{{ asset('images/demo_bg.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">

            <div class="w-full max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-200">
                <div class="flex justify-center mt-5 mb-2">
                    <img src="/images/logo.png" class="w-32 h-auto"/>
                </div>
                <div>
                    {{ $slot }}
                </div>
            </div>
        </div>

    </div>

</body>

</html>
