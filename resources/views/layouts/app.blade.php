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

    @vite(['resources/css/app.css', 'resources/js/app.js','node_modules/@fortawesome/fontawesome-free/css/all.css'])


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

        function toggleSelection(array,item) {
            const index = array.indexOf(item);
            if (index === -1) {
            array.push(item);
            } else {
                array.splice(index, 1);
            }
        }

        function submitFilterForm(event,categories,brands){
            event.preventDefault();

            console.log(categories, brands);

            const joinedCategories = categories.map(category => encodeURIComponent(category)).join("|");
            const joinedBrands = brands.map(brand => encodeURIComponent(brand)).join("|");
            const currentSiteUrl = window.location.href.split('?')[0];
            console.log(joinedCategories);

            const encodedUrl = `${currentSiteUrl}?categories=${joinedCategories==='[]'?'':joinedCategories}&brands=${joinedBrands==='[]'?'':joinedBrands}`;
            const url = encodeURI(encodedUrl);

            window.location.href = url;
        }

        function onContinueClicked(isWebPay=false,phoneNumber,paymentId,paymentCode){
            if(isWebPay){
                submitWebPayForm()
                return;
            }else{
                getQrImage(phoneNumber,paymentId,paymentCode)
            }
        }

        function submitWebPayForm(){
            const webPayForm = document.getElementById('webPayForm');
            webPayForm.submit();
        }

        function getQrImage(phoneNumber,paymentId,paymentCode){
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch('/api/non-web-pay', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    paymentId:paymentId,
                    paymentCode:paymentCode,
                    phoneNumber:phoneNumber
                })
            })
                .then(response => {
                    // Handle the response
                })
                .catch(error => {
                    // Handle the error
                });

        }


    // Apply dark mode immediately
        const darkModePreference = setDarkModePreference();
        setDarkMode(darkModePreference);
    </script>
    <!-- Scripts -->

</head>

<body class="font-sans antialiased" :class="{ 'dark': dark}" x-data="{ dark: setDarkModePreference(), toggleTheme: function() { this.dark = !this.dark; localStorage.setItem('dark', this.dark);document.documentElement.classList.toggle('dark', this.dark)},isCartShown:'{{@session('isCartShown')==1}}'}" x-init="setDarkMode(dark)">
            <div class="min-h-screen bg-gray-100 dark:bg-gray-700">
                @include('layouts.navigation')
                <main class="px-2 lg:px-12">
                    {{ $slot }}
                </main>
            </div>
</body>

</html>
