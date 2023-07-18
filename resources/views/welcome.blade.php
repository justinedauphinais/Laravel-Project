<!DOCTYPE html>
<!-- /*****************************************************************************
Fichier : welcome.blade.php
Auteur : Louis-Philippe Racette
Fonctionnalité : Accueil pour les invités pour se login ou register
Date : 2023-04-29
*****************************************************************************/-->
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
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/nav.js'])
    <script src="https://kit.fontawesome.com/7dfc4ecd43.js" crossorigin="anonymous"></script>
</head>

<body class="antialiased">


    <body class="font-sans antialiased">
        <div class="min-h-screen z-50">
            @include('layouts.navigation')

            <!-- Page Content -->
            <main class="mt-2">
                <div class="py-12">
                    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 ">
                        <div
                            class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-4 border-dark-red drop-shadow-boite mb-6 py-6 px-8">
                            <h2 class="text-center font-bold text-3xl mb-6">{{ __('Bienvenue ') }} !</h2>
                            <p>{{ __('Bienvenue sur Event-o-matic, la plateforme en ligne qui simplifie la création et la participation à des événements.') }}
                            </p>
                            <br>
                            <p>
                                {{ __('Vous cherchez à organiser un mariage, un anniversaire, une conférence ou un concert ? Event-o-matic est là pour vous aider à planifier chaque étape de votre événement de manière facile et efficace. Notre interface conviviale vous permet de créer votre événement en quelques clics seulement. Ajoutez les détails de votre événement, choisissez la date et l\'heure, et voilà!') }}
                            </p>
                            <br>
                            <p>
                                {{ __('Vous cherchez à participer à un événement ? Notre plateforme vous permet de trouver des événements à proximité de chez vous ou partout dans le monde. Vous pouvez filtrer les événements par date, type d\'événement et même par nom. Vous pouvez également discuter avec les organisateurs et commenter votre expérience sur un événement.') }}
                            </p>
                            <br>
                            <p>
                                {{ __('Event-o-matic est une plateforme conviviale, conçue pour faciliter la création et la participation à des événements. Nous avons rassemblé des fonctionnalités utiles pour les organisateurs et les participants afin de rendre votre expérience aussi agréable que possible. Inscrivez-vous dès maintenant et commencez à créer et participer à des événements sur Event-o-matic!') }}
                            </p>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>

</body>

</html>

<style>
    body {
        background-image: url({{ asset('img/background.png') }});
        background-repeat: no-repeat;
        background-size: cover;

    }
</style>
