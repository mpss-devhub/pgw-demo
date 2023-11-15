<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased" x-data="{ dark: setDarkModePreference(), toggleTheme: function() { this.dark = !this.dark; localStorage.setItem('dark', this.dark); document.documentElement.classList.toggle('dark', this.dark); }, isCartShown: {{ @session('isCartShown') == 1 ? 'true' : 'false' }} }" x-init="setDarkMode(dark)">
<div class="h-screen bg-gray-100 relative" style="background-image: url('{{ asset('images/demo_bg.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">

    <div class="top-0 left-0 fixed w-full">
        @include('layouts.guest-navigation')
    </div>

    <!-- Main Content -->
    <main  class="w-full h-full flex items-center justify-center">
        {{ $slot }}
    </main>

</div>
</body>

</html>
