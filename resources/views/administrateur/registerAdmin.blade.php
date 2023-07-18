<!--/*****************************************************************************
 Fichier : registerAdmin.blade.php
 Auteur : Justine Dauphinais
 Fonctionnalité : Inscription d'un nouvel administrateur
 Date : 26 avril 2023
*****************************************************************************/-->

<x-app-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="px-16 py-4 drop-shadow-boite border-2 border-dark-red bg-white shadow sm:rounded-lg">
                <form method="POST" action="{{ route('registerAdministrateurPost') }}">
                    @csrf

                    <h1 class="text-2xl text-center font-fjalla">{{ __('Ajouter un compte administrateur') }}</h1>

                    <!-- Nom -->
                    <div class="flex flex-col md:flex-row mt-4">
                        <x-input-label for="nom" :value="__('Nom : ')" class="block w-full md:w-60 mt-0 md:mt-3 font-fjalla" />
                        <div class="block w-full">
                            <x-text-input id="nom" class="block w-full font-fjalla" type="text" name="nom" :value="old('nom')" autofocus />
                            <x-input-error :messages="$errors->get('nom')" class="mt-2 font-fjalla" />
                        </div>
                    </div>

                    <!-- Prénom -->
                    <div class="flex flex-col md:flex-row mt-4">
                        <x-input-label for="prenom" :value="__('Prénom : ')" class="block w-full md:w-60 mt-0 md:mt-3 font-fjalla" />
                        <div class="block w-full">
                            <x-text-input id="prenom" class="block w-full font-fjalla" type="text" name="prenom" :value="old('nom')" />
                            <x-input-error :messages="$errors->get('prenom')" class="mt-2 font-fjalla" />
                        </div>
                    </div>

                    <!-- Date de naissance -->
                    <div class="flex flex-col md:flex-row mt-4">
                        <x-input-label for="date_naissance" :value="__('Date de naissance : ')" class="block w-full md:w-60 mt-0 md:mt-3 font-fjalla" />
                        <div class="block w-full">
                            <x-text-input id="date_naissance" class="block w-full font-fjalla" type="date" name="date_naissance" :value="old('date_naissance')" />
                            <x-input-error :messages="$errors->get('date_naissance')" class="mt-2 font-fjalla" />
                        </div>
                    </div>

                    <!-- Courriel -->
                    <div class="flex flex-col md:flex-row mt-4">
                        <x-input-label for="email" :value="__('Courriel : ')" class="block w-full md:w-60 mt-0 md:mt-3 font-fjalla" />
                        <div class="block w-full">
                            <x-text-input id="email" class="block w-full font-fjalla" type="text" name="email" :value="old('email')" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 font-fjalla" />
                        </div>
                    </div>

                    <!-- Numéro de téléphone -->
                    <div class="flex flex-col md:flex-row mt-4">
                        <x-input-label for="numero_telephone" :value="__('Numéro de téléphone : ')" class="block w-full md:w-60 mt-0 md:mt-3 font-fjalla" />
                        <div class="block w-full">
                            <x-text-input id="numero_telephone" class="block w-full font-fjalla" type="tel" name="numero_telephone" :value="old('numero_telephone')" />
                            <x-input-error :messages="$errors->get('numero_telephone')" class="mt-2 font-fjalla" />
                        </div>
                    </div>

                    <!-- Mot de passe -->
                    <div class="flex flex-col md:flex-row mt-4">
                        <x-input-label for="password" :value="__('Mot de passe : ')" class="block w-full md:w-60 mt-0 md:mt-3 font-fjalla" />
                        <div class="block w-full">
                            <x-text-input id="password" class="block w-full font-fjalla" type="password" name="password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 font-fjalla" />
                        </div>
                    </div>

                    <!-- Confirmer mot de passe -->
                    <div class="flex flex-col md:flex-row mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirmer mot de passe : ')" class="block w-full md:w-60 mt-0 md:mt-3 font-fjalla" />
                         <div class="block w-full">
                            <x-text-input id="password_confirmation" class="block w-full font-fjalla" type="password" name="password_confirmation" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 font-fjalla" />
                         </div>
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <a href={{ url('/') }} class="bg-pale-yellow px-6 py-1 rounded-md border border-gray-900 font-fjalla" type="button">
                            {{ __('Annuler') }}
                        </a>

                        <button class="bg-medium-yellow px-6 py-1 rounded-md border border-gray-900 font-fjalla" type="reset">
                            {{ __('Réinitialiser') }}
                        </button>

                        <button class="bg-dark-yellow px-6 py-1 rounded-md border border-gray-900 font-fjalla" type="submit">
                            {{ __('Ajouter') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
