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
        <link href="https://fonts.googleapis.com/css2?family=Fjalla+One&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/nav.js'])
        <script src="https://kit.fontawesome.com/7dfc4ecd43.js" crossorigin="anonymous"></script>
    </head>

    <body class="font-sans antialiased text-gray-900">
        @include('layouts.navigation')
        <div class="absolute top-0 left-0 flex flex-col items-center w-full min-h-screen pt-6 sm:justify-center sm:pt-0">

            <main class="w-full px-6 py-4 overflow-hidden bg-white shadow-md sm:w-6/12 sm:rounded-lg">

                {{ $slot }}
            </main>
        </div>
    </body>
</html>

<style>
    body {
        background-image: url({{ asset("img/background.png") }});
        background-repeat: no-repeat;
        background-size: 100%;
    }
</style>
