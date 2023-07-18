<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Fjalla+One&display=swap" rel="stylesheet">

        <!-- Scripts -->

        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/indexUtilisateurs.js', 'resources/js/nav.js','resources/js/categorie.js', 'resources/js/evenement.js'])
        <script src="https://kit.fontawesome.com/7dfc4ecd43.js" crossorigin="anonymous"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen">
            @include('layouts.modale')
            @include('layouts.navigation')
            @include('layouts.modaleCategorie')


            <!-- Page Content -->
            <main class="mt-2">
                {{ $slot }}
            </main>
        </div>
    </body>


</html>

<style>
    body {
        background-image: url({{ asset('img/background.png') }});
        background-repeat: no-repeat;
        background-size: cover;

    }
</style>
