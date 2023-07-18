<!-- /*****************************************************************************
Fichier : evenements.balde.php
Auteur : Louis-Philippe Racette
Fonctionnalité : S'occupe de la recherche d'événements pour organisateur et admin
Date : 2023-04-27
*****************************************************************************/-->


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Les événements') }}
        </h2>
    </x-slot>

    <!--Mieu implémenter la gestion des erreurs-->
    @if ($errors->any())
        <div class="max-w-5xl bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mx-auto mt">
            <p>{{ __('Veuillez corriger l\'erreur ou les erreurs suivante(s) :') }}</p>
            <ul class="list-disc list-inside pl-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (Session::has('succes'))
        <div role="alert">
            <div class="bg-green-500 text-white font-bold rounded-t px-4 py-2">Succès</div>
            <div class="border border-t-0 border-green-400 rounded-b bg-green-100 px-4 py-3 text-green-700">
                <p>{{ Session::get('succes') }}</p>
            </div>
        </div>
    @elseif (Session::has('erreur'))
        <div role="alert">
            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">Erreur</div>
            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                <p>{{ Session::get('erreur') }}</p>
            </div>
        </div>
    @endif
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 ">
            <div
                class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-4 border-dark-red drop-shadow-boite mb-6">
                <div class="p-12 pb-6 pt-6 text-gray-900">
                    @if (Route::is('afficherEvenementsOrganisateur'))
                        <form action="{{ route('afficherEvenementsOrganisateur') }}" method="get">
                        @else
                            <form action="{{ route('afficherEvenementsAdmin') }}" method="get">
                    @endif
                    @csrf
                    <p class="text-center font-bold text-2xl">{{ __('Rechercher des événements') }}</p>
                    @if (Route::is('afficherEvenementsOrganisateur'))
                        <div class="grid grid-flow-row-dense grid-cols-5 gap-8  gap-y-2">
                        @else
                            <div class="grid grid-flow-row-dense grid-cols-4 gap-10  gap-y-2">
                    @endif
                    <div>
                        <label for="titre">{{ __('Nom:') }}</label>
                    </div>
                    <div>
                        <label for="date">{{ __('Date:') }}</label>

                    </div>
                    @if (Route::is('afficherEvenementsOrganisateur'))
                        <div class="col-span-3">
                        @else
                            <div class="col-span-2">
                    @endif
                    <label for="categorie">{{ __('Catégorie:') }}</label>

                </div>

                <!--Deuxieme range-->
                <div>
                    <input
                        class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        type="text" name="titre" id="titre">

                </div>
                <div>
                    <input class="border rounded py-1 w-full leading-tight" type="date" name="date"
                        id="date">

                </div>
                <div>
                    <select
                        class="block appearance-none w-full border text-gray-700 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="categorie" name="categorie">
                        <option value="0">{{ __('Aucun') }}</option>
                        @foreach ($categories as $categorie)
                            <option value="{{ $categorie->id }}"
                                @if ($categorie->id == old('categorie')) {{ 'selected' }} @endif>
                                {{ $categorie->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button class="border rounded border-black bg-dark-yellow font-bold px-2"
                        type="submit">{{ __('Rechercher') }}</button>
                </div>
                @if (Route::is('afficherEvenementsOrganisateur'))
                    <div><a class="underline" href="{{ route('formulaireEvenement') }}">{{ 'Créer un événement' }}</a>
                    </div>
                @endif
            </div>
            </form>
        </div>
    </div>
    </div>

    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 grid grid-flow-row-dense grid-cols-3 gap-16  gap-y-2">
        <!--TODO ajouter les images dynamiques-->
        @if ($evenements != null)
            @foreach ($evenements as $evenement)
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-4 border-dark-red drop-shadow-boite mb-6 pb-3">
                    <img src="{{ asset('img/evenementbase.jpg') }}" alt="" srcset="">
                    <p class="text-center font-bold text-base py-2">{{ $evenement->nom }}</p>
                    <div class="text-center">
                        <form method="get" action="{{ (Auth::user()->id_role == 1 ? route('formulaireEvenementAdmin') : route('formulaireModifEvenement')) }}">
                            @csrf
                            <input type="hidden" name="id_evenement" value="{{ $evenement->id }}">
                            <button type="submit"
                                class="border rounded border-black bg-pale-yellow text-center text-base p-1">
                                {{ __('Consulter') }}
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        @else
            <p class="bg-white rounded drop-shadow-boite border-4 border-dark-red py-2 text-center font-bold text-xl col-span-3">
                {{ __('Il n\'y a aucun résultat!') }}</p>
        @endif

    </div>
    </div>
</x-app-layout>
