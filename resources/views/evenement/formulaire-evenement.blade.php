<!--/*****************************************************************************
Fichier : formulaire-evenement.blade.php
Auteur : Louis-Philippe Racette
Fonctionnalité : S'occupe de l'affichage du formulaire pour ajouter un événement
Date : 2023-04-27
*****************************************************************************/-->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Création d\'un événement') }}
        </h2>
    </x-slot>

    <!--Mieu implémenter la gestion des erreurs-->
    @if ($errors->any())
        <div class="max-w-5xl bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mx-auto mt">
            <p>Veuillez corriger l'erreur ou les erreurs suivante(s) :</p>
            <ul class="list-disc list-inside pl-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-4 border-dark-red drop-shadow-boite">
                <div class="p-12 pb-6 pt-6 text-gray-900">
                    <form action="{{ route('ajouterEvenement') }}" method="post">
                        @csrf
                        <fieldset>
                            <legend class="text-2xl font-bold text-center pb-4">{{ __('À propos') }}</legend>

                            <div class="grid grid-cols-6 gap-2 gap-y-6">

                                <!-- Premiere range -->

                                <div class="flex flex-col justify-center items-start">
                                    <label for="titre">{{ __('Titre:') }}</label>
                                </div>
                                <div>
                                    <input
                                        class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        type="text" name="titre" id="titre" value="{{ old('titre') }}">
                                </div>
                                <div class="flex flex-col justify-center items-start">
                                    <label for="etat">{{ __('État:') }}</label>
                                </div>
                                <div>
                                    <select
                                        class="block appearance-none w-full bg-white border text-gray-700 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        id="etat" name="etat">
                                        @foreach ($statuts as $statut)
                                            <option value="{{ $statut->id }}"
                                                @if ($statut->id == old('etat')) {{ 'selected' }} @endif>
                                                {{ $statut->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex flex-col justify-center items-start">
                                    <label for="code_postal">{{ __('Code postal:') }}</label>
                                </div>
                                <div>
                                    <input
                                        class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        type="text" name="code_postal" id="code_postal"
                                        value="{{ old('code_postal') }}">
                                </div>

                                <!-- Deuxieme range -->

                                <div class="flex flex-col justify-center items-start">
                                    <label for="adresse">{{ __('Adresse avec la rue:') }}</label>
                                </div>
                                <div>
                                    <input
                                        class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        type="text" name="adresse" id="adresse" value="{{ old('adresse') }}">
                                </div>
                                <div class="flex flex-col justify-center items-start">
                                    <label for="lien">{{ __('Lien:') }}</label>
                                </div>
                                <div>
                                    <input
                                        class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        type="text" name="lien" id="lien" value="{{ old('lien') }}">
                                </div>
                                <div class="flex flex-col justify-center items-start">
                                    <label for="ville">{{ __('Ville:') }}</label>
                                </div>
                                <div>
                                    <select
                                        class="block appearance-none w-full bg-white border text-gray-700 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        id="ville" name="ville">
                                        @foreach ($villes as $ville)
                                            <option value="{{ $ville->id }}"
                                                @if ($ville->id == old('ville')) {{ 'selected' }} @endif>
                                                {{ $ville->nom }}</option>
                                        @endforeach
                                    </select>

                                </div>

                                <!-- Troisième range -->

                                <div class="flex flex-col justify-center items-start">
                                    <label for="pays">{{ __('Pays:') }}</label>
                                </div>
                                <div>
                                    <select
                                        class="block appearance-none w-full bg-white border text-gray-700 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        id="pays" name="pays">

                                        @foreach ($pays as $country)
                                            <option value="{{ $country->id }}"
                                                @if ($country->id == old('pays')) {{ 'selected' }} @endif>
                                                {{ $country->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex flex-col justify-center items-start">
                                    <label for="categorie">{{ __('Catégorie:') }}</label>
                                </div>
                                <div>
                                    <select
                                        class="block appearance-none w-full bg-white border text-gray-700 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        id="categorie" name="categorie">
                                        @foreach ($categories as $categorie)
                                            <option value="{{ $categorie->id }}"
                                                @if ($categorie->id == old('categorie')) {{ 'selected' }} @endif>
                                                {{ $categorie->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex flex-col justify-center items-start">
                                    <label for="prix_billet">{{ __('Prix billet:') }}</label>
                                </div>
                                <div>
                                    <input
                                        class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        type="text" name="prix_billet" id="prix_billet"
                                        value="{{ old('prix_billet') }}">
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend class="text-2xl font-bold text-center py-4">{{ __('Représentations') }}</legend>

                            <div class="grid grid-flow-row-dense grid-cols-6 gap-2  gap-y-2">

                                <!-- Premiere range -->

                                <div class="flex flex-col justify-center items-start">
                                    <label for="date1">{{ __('Date 1:') }}</label>
                                </div>
                                <div>
                                    <input class="border rounded py-1 w-full" type="datetime-local" name="date1"
                                        id="date1" value="{{ old('date1') }}">
                                </div>
                                <div class="flex flex-col justify-center items-start">
                                    <label for="date2">{{ __('Date 2:') }}</label>
                                </div>
                                <div>
                                    <input class="border rounded py-1 w-full" type="datetime-local" name="date2"
                                        id="date2" value="{{ old('date2') }}">
                                </div>
                                <div class="flex flex-col justify-center items-start">
                                    <label for="date3">{{ __('Date 3:') }}</label>
                                </div>
                                <div>
                                    <input class="border rounded py-1 w-full" type="datetime-local" name="date3"
                                        id="date3" value="{{ old('date3') }}">
                                </div>

                                <!-- Deuxieme range -->

                                <div class="flex flex-col justify-center items-start">
                                    <label for="nombre_billet1">{{ __('Nombre de billet:') }}</label>
                                </div>
                                <div>
                                    <input
                                        class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        type="text" name="nombre_billet1" id="nombre_billet1"
                                        value="{{ old('nombre_billet1') }}">
                                </div>
                                <div class="flex flex-col justify-center items-start">
                                    <label for="nombre_billet2">{{ __('Nombre de billet:') }}</label>
                                </div>
                                <div>
                                    <input
                                        class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        type="text" name="nombre_billet2" id="nombre_billet2"
                                        value="{{ old('nombre_billet2') }}">
                                </div>
                                <div class="flex flex-col justify-center items-start">
                                    <label for="nombre_billet3">{{ __('Nombre de billet:') }}</label>
                                </div>
                                <div>
                                    <input
                                        class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        type="text" name="nombre_billet3" id="nombre_billet3"
                                        value="{{ old('nombre_billet3') }}">
                                </div>

                                <!-- Troisième range -->

                                <div class="col-span-2">
                                    <input type="checkbox" name="representation_active1" id="representation_active1"
                                        class="me-1" {{ old('representation_active1') == 'on' ? 'checked' : '' }}>
                                    <label class="text-sm"
                                        for="representation_active1">{{ __('représentation active') }}</label>
                                </div>

                                <div class="col-span-2">
                                    <input type="checkbox" name="representation_active2" id="representation_active2"
                                        class="me-1" {{ old('representation_active2') == 'on' ? 'checked' : '' }}>
                                    <label class="text-sm"
                                        for="representation_active2">{{ __('représentation active') }}</label>
                                </div>

                                <div class="col-span-2">
                                    <input type="checkbox" name="representation_active3" id="representation_active3"
                                        class="me-1" {{ old('representation_active3') == 'on' ? 'checked' : '' }}>
                                    <label class="text-sm"
                                        for="representation_active3">{{ __('représentation active') }}</label>
                                </div>
                            </div>
                        </fieldset>

                        <div class="flex flex-row justify-center item-center mt-8">
                            <!--TODO Ajouter route vers mes événements-->
                            <a href="{{ route('afficherEvenementsOrganisateur') }}"
                                class="w-1/6 border rounded border-black bg-pale-yellow text-center font-bold">{{ __('Annuler') }}</a>
                            <button class="w-1/6 border mx-12 rounded border-black bg-medium-yellow font-bold"
                                type="reset">{{ __('Réinitialiser') }}</button>
                            <button class="w-1/6 border rounded border-black bg-dark-yellow font-bold"
                                type="submit">{{ __('Créer') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
