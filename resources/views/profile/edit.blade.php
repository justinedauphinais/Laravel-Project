<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border-2 border-dark-red drop-shadow-boite">
                <div>
                    <h1 class="font-fjalla text-3xl text-center mb-5">{{__('Mon profil')}}</h1>
                    <div class="flex mb-4">
                        <p class="font-fjalla text-right w-full">{{__('Nom complet : ')}}</p>
                        <p class="font-fjalla text-left w-full ml-1">{{ $user->prenom . ' ' . $user->nom }}</p>
                    </div>
                    <div class="flex mb-4">
                        <p class="font-fjalla text-right w-full">{{__('Courriel : ')}}</p>
                        <p class="font-fjalla text-left w-full ml-1">{{ $user->email }}</p>
                    </div>
                    <div class="flex">
                        <p class="font-fjalla text-right w-full">{{__('Numéro de téléphone : ')}}</p>
                        <p class="font-fjalla text-left w-full ml-1">{{ $user->numero_telephone }}</p>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border-2 border-dark-red drop-shadow-boite">
                <div class="px-20">
                    <h2 class="font-fjalla text-2xl text-center mb-5">{{__('Modifier')}}</h2>

                    <?php
                        if (isset($modifier)) {
                            if ($modifier == FALSE) { ?>
                                <div class="w-9/12 mx-auto my-4 text-center border-2 border-red-700 py-3 bg-red-200 rounded-md font-fjalla text-red-700">
                                    <p>{{ __("Une erreur est survenue.") }}</p>
                                    <p>{{ __('Veuillez réessayer plus tard.') }}</p>
                                </div>
                            <?php }
                            else if ($modifier == TRUE) { ?>
                                <div class="w-9/12 mx-auto my-4 text-center border-2 border-green-600 py-3 bg-green-100 rounded-md font-fjalla text-green-600">
                                    <p>{{ __('La modification s\'est bien effectuée.') }}</p>
                                </div>
                            <?php }
                        }
                    ?>

                    <form action="{{ route("profile.update") }}" method="post">
                        @csrf
                        <div class="px-12">
                            <div class="flex mb-4">
                                <p class="font-fjalla w-full">{{__('Nom : ')}}</p>
                                <div class="w-full flex flex-col">
                                    <input type="text" name="nom" class="font-fjalla w-full ml-1 py-0 rounded-md" placeholder={{ $user->nom }} />
                                    <x-input-error :messages="$errors->get('nom')" class="font-fjalla mt-2 ml-1" />
                                </div>
                            </div>

                            <div class="flex mb-4">
                                <p class="font-fjalla w-full">{{__('Prénom : ')}}</p>
                                <div class="w-full flex flex-col">
                                    <input type="text" name="prenom" class="font-fjalla w-full ml-1 py-0 rounded-md" placeholder={{ $user->prenom }} />
                                    <x-input-error :messages="$errors->get('prenom')" class="font-fjalla mt-2 ml-1" />
                                </div>
                            </div>

                            @if ($user->id_role != 1)
                                <div class="flex mb-4">
                                    <p class="font-fjalla w-full">{{__('Ville : ')}}</p>
                                    <div class="w-full flex flex-col">
                                        <select name="ville" id="ville" class="font-fjalla w-full ml-1 py-0 rounded-md" >
                                            @foreach ($villes as $ville)
                                                <option value={{ $ville->id }} <?php if ($user->id_ville == $ville->id) { echo 'selected'; }  ?>>{{ $ville->nom }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('ville')" class="font-fjalla mt-2" />
                                    </div>
                                </div>
                            @endif

                            <div class="flex mb-4">
                                <p class="font-fjalla w-full">{{__('Courriel : ')}}</p>
                                <div class="w-full flex flex-col">
                                    <input type="text" name="email" class="font-fjalla w-full ml-1 py-0 rounded-md" placeholder={{ $user->email }} />
                                    <x-input-error :messages="$errors->get('email')" class="font-fjalla mt-2 ml-1" />
                                </div>
                            </div>

                            <div class="flex mb-4">
                                <p class="font-fjalla w-full">{{__('Numéro de téléphone : ')}}</p>
                                <div class="w-full flex flex-col">
                                    <input type="text" name="numero_telephone" class="font-fjalla w-full ml-1 py-0 rounded-md" placeholder={{ $user->numero_telephone }} />
                                    <x-input-error :messages="$errors->get('nom')" class="font-fjalla mt-2 ml-1" />
                                </div>
                            </div>

                            <div class="flex mb-4">
                                <p class="font-fjalla w-full">{{__('Mot de passe : ')}}</p>
                                <div class="w-full flex flex-col">
                                    <input type="password" name="password" class="font-fjalla w-full ml-1 py-0 rounded-md" placeholder={{ __('Caché') }} />
                                    <x-input-error :messages="$errors->get('nom')" class="font-fjalla mt-2 ml-1" />
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between">
                            <a href={{ url('/') }} class="font-fjalla bg-pale-yellow px-6 py-1 rounded-md border border-gray-900" type="button">
                                {{ __('Annuler') }}
                            </a>

                            <button class="font-fjalla bg-medium-yellow px-6 py-1 rounded-md border border-gray-900" type="reset">
                                {{ __('Réinitialiser') }}
                            </button>

                            <button class="font-fjalla bg-dark-yellow px-6 py-1 rounded-md border border-gray-900" type="submit">
                                {{ __('Modifier') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
