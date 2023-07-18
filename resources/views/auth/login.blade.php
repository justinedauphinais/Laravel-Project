<!--/*****************************************************************************
 Fichier : login.blade.php
 Auteur : Justine Dauphinais
 Fonctionnalité : Connexion de tous les utilisateurs
 Date : 26 avril 2023
*****************************************************************************/-->

<x-app-layout>
    <div class="mt-40 w-full flex flex-col sm:justify-center items-center">
        <div class="w-full sm:w-6/12 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg mx-auto">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <h1 class="font-fjalla text-2xl text-center mb-4 font-bold">{{ __('Connexion') }}</h1>

            <x-input-error :messages="$errors->get('error')" class="font-fjalla mt-2" />
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="flex flex-column md:flex-row mb-2">
                    <!-- Courriel -->
                    <div class="w-6/12 pe-2">
                        <x-text-input id="email" class="font-fjalla block mt-1 w-full"
                                        type="email"
                                        name="email"
                                        :value="old('email')" required autofocus autocomplete="username"
                                        placeholder="{{ __('Courriel') }}" />
                    </div>

                    <!-- Mot de passe -->
                    <div class="w-6/12">
                        <x-text-input id="password" class="font-fjalla block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password"
                                        placeholder="{{ __('Mot de passe') }}" />
                    </div>
                </div>

                @if (Route::has('password.request'))
                    <div class="flex justify-end">
                        <a class="font-fjalla ml-4 bg-zinc-300 hover:bg-zinc-400 w-6/12 pl-2 py-1 rounded-md border border-gray-900" href="{{ route('password.request') }}">
                            {{ __('Mot de passe oublié?') }}
                        </a>
                    </div>
                @endif

                <div class="flex flex-col justify-center mt-4">
                    <!-- Remember Me -->
                    <div class="block mt-4 m-auto">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                            <span class="font-fjalla ml-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</span>
                        </label>
                    </div>

                    <button class="font-fjalla bg-dark-yellow font-bold px-6 py-1 rounded-md border border-gray-900 block m-auto mt-4 uppercase" type="submit">
                        {{ __('Connexion') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
