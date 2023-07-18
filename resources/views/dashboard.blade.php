<!-- /*****************************************************************************
Fichier : dashboard.balde.php
Auteur : Louis-Philippe Racette
Fonctionnalité : Accueil quand on est login
Date : 2023-04-29
*****************************************************************************/-->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 ">
            <div
                class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-4 border-dark-red drop-shadow-boite mb-6 p-6 ">
                <h2 class="text-center font-bold text-3xl mb-6">{{ __('Bienvenue ') }} {{ Auth::user()->prenom }} !</h2>
                <p>{{ __('Bienvenue sur Event-o-matic, la plateforme en ligne qui simplifie la création et la participation à des événements.
                                                                                                Vous cherchez à organiser un mariage, un anniversaire, une conférence ou un concert ? Event-o-matic est là pour vous aider à
                                                                                                 planifier chaque étape de votre événement de manière facile et efficace. Notre interface conviviale vous permet de créer votre
                                                                                                  événement en quelques clics seulement. Ajoutez les détails de votre événement, choisissez la date et l\'heure, et voilà!
                                                                                                ') }}
                </p>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
