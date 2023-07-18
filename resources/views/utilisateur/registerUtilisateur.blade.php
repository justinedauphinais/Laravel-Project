<!--/*****************************************************************************
 Fichier : registerUtilisateur.blade.php
 Auteur : Justine Dauphinais
 Fonctionnalité : Inscription d'un nouvel utilisateur
 Date : 26 avril 2023
*****************************************************************************/-->

<x-app-layout>
    <div class="mt-10 mb-5 w-full flex flex-col sm:justify-center items-center">
        <div class="w-full sm:w-6/12 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg mx-auto">
            <form method="POST" action="{{ route('registerUtilisateur') }}">
                @csrf

                <h1 class="font-fjalla text-2xl text-center">{{__('Inscription utilisateur')}}</h1>

                <!-- Nom -->
                <div class="flex flex-col md:flex-row mt-4">
                    <x-input-label for="nom" :value="__('Nom : ')" class="font-fjalla block w-full md:w-60 mt-0 md:mt-3" />
                    <div class="block w-full">
                        <x-text-input id="nom" class="font-fjalla block w-full" type="text" name="nom" :value="old('nom')" autofocus />
                        <x-input-error :messages="$errors->get('nom')" class="font-fjalla mt-2" />
                    </div>
                </div>

                <!-- Prénom -->
                <div class="flex flex-col md:flex-row mt-4">
                    <x-input-label for="prenom" :value="__('Prénom : ')" class="font-fjalla block w-full md:w-60 mt-0 md:mt-3" />
                    <div class="block w-full">
                        <x-text-input id="prenom" class="font-fjalla block w-full" type="text" name="prenom" :value="old('nom')" />
                        <x-input-error :messages="$errors->get('prenom')" class="font-fjalla mt-2" />
                    </div>
                </div>

                <!-- Date de naissance -->
                <div class="flex flex-col md:flex-row mt-4">
                    <x-input-label for="date_naissance" :value="__('Date de naissance : ')" class="font-fjalla block w-full md:w-60 mt-0 md:mt-3" />
                    <div class="block w-full">
                        <x-text-input id="date_naissance" class="font-fjalla block w-full" type="date" name="date_naissance" :value="old('date_naissance')" />
                        <x-input-error :messages="$errors->get('date_naissance')" class="font-fjalla mt-2" />
                    </div>
                </div>

                <!-- Ville -->
                <div class="flex flex-col md:flex-row mt-4">
                    <x-input-label for="ville" :value="__('Date de naissance : ')" class="font-fjalla block w-full md:w-60 mt-0 md:mt-3" />
                    <div class="block w-full">
                        <select name="ville" id="ville" class="font-fjalla block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" >
                            @foreach ($villes as $ville)
                                <option value={{ $ville->id }}>{{ $ville->nom }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('ville')" class="font-fjalla mt-2" />
                    </div>
                </div>

                <!-- Courriel -->
                <div class="flex flex-col md:flex-row mt-4">
                    <x-input-label for="email" :value="__('Courriel : ')" class="font-fjalla block w-full md:w-60 mt-0 md:mt-3" />
                    <div class="block w-full">
                        <x-text-input id="email" class="font-fjalla block w-full" type="email" name="email" :value="old('email')" />
                        <x-input-error :messages="$errors->get('email')" class="font-fjalla mt-2" />
                    </div>
                </div>

                <!-- Numéro de téléphone -->
                <div class="flex flex-col md:flex-row mt-4">
                    <x-input-label for="numero_telephone" :value="__('Numéro de téléphone : ')" class="font-fjalla block w-full md:w-60 mt-0 md:mt-3" />
                    <div class="block w-full">
                        <x-text-input id="numero_telephone" class="font-fjalla block w-full" type="tel" name="numero_telephone" :value="old('numero_telephone')" />
                        <x-input-error :messages="$errors->get('numero_telephone')" class="font-fjalla mt-2" />
                    </div>
                </div>

                <!-- Mot de passe -->
                <div class="flex flex-col md:flex-row mt-4">
                    <x-input-label for="password" :value="__('Mot de passe : ')" class="font-fjalla block w-full md:w-60 mt-0 md:mt-3" />
                    <div class="block w-full">
                        <x-text-input id="password" class="font-fjalla block w-full" type="password" name="password" />
                        <x-input-error :messages="$errors->get('password')" class="font-fjalla mt-2" />
                    </div>
                </div>

                <!-- Confirmer mot de passe -->
                <div class="flex flex-col md:flex-row mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirmer mot de passe : ')" class="font-fjalla block w-full md:w-60 mt-0 md:mt-3" />
                     <div class="block w-full">
                        <x-text-input id="password_confirmation" class="font-fjalla block w-full" type="password" name="password_confirmation" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="font-fjalla mt-2" />
                     </div>
                </div>

                <div class="flex items-center justify-between mt-4">
                    <a href={{ url('/') }} class="font-fjalla bg-pale-yellow px-6 py-1 rounded-md border border-gray-900" type="button">
                        {{ __('Annuler') }}
                    </a>

                    <button class="font-fjalla bg-medium-yellow px-6 py-1 rounded-md border border-gray-900" type="reset">
                        {{ __('Réinitialiser') }}
                    </button>

                    <button class="font-fjalla bg-dark-yellow px-6 py-1 rounded-md border border-gray-900" type="submit">
                        {{ __('Ajouter') }}
                    </button>
                </div>

                <a href={{ url('/register/organisateur') }} class="block font-fjalla text-right mt-2 underline hover:text-pale-blue">{{ __("Inscription organisateur") }}</a>
            </form>
        </div>
    </div>
</x-app-layout>
