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
    <!-- Scripts -->

</head>

<body class="font-sans antialiased" :class="{ 'dark': dark }" x-data="{ dark: setDarkModePreference(), toggleTheme: function() { this.dark = !this.dark; localStorage.setItem('dark', this.dark);document.documentElement.classList.toggle('dark', this.dark)} }" x-init="setDarkMode(dark)">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-700">
        @include('layouts.navigation')

        <main class="px-2 lg:px-12">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
