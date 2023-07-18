<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-2 drop-shadow-boite border-2 border-dark-red bg-white shadow sm:rounded-lg">
                <h1 class="text-3xl font-fjalla font-bold text-center w-full mb-3">{{__('Utilisateur')}}</h1>

                <!-- Nom -->
                <div class="flex flex-col md:flex-row gap-1 mt-4">
                    <p class="block w-full font-fjalla text-right text-gray-700">{{ __('Nom : ') }}</p>
                    <p class="block w-full font-fjalla">{{ $user->nom }}</p>
                </div>

                <!-- Prénom -->
                <div class="flex flex-col md:flex-row gap-1 mt-4">
                    <p class="block w-full font-fjalla text-right text-gray-700">{{ __('Prénom : ') }}</p>
                    <p class="block w-full font-fjalla">{{ $user->prenom }}</p>
                </div>

                <!-- Date de naissance -->
                <div class="flex flex-col md:flex-row gap-1 mt-4">
                    <p class="block w-full font-fjalla text-right text-gray-700">{{ __('Date de naissance : ') }}</p>
                    <p class="block w-full font-fjalla">{{ $user->date_naissance }}</p>
                </div>

                <!-- Date de naissance -->
                <div class="flex flex-col md:flex-row gap-1 mt-4">
                    <p class="block w-full font-fjalla text-right text-gray-700">{{ __('Ville : ') }}</p>
                    <p class="block w-full font-fjalla">
                        @if ($user->id_ville == null)
                            {{ __('Aucune ville') }}
                        @else
                            {{ $user->ville->nom }}
                        @endif
                    </p>
                </div>

                <!-- Courriel -->
                <div class="flex flex-col md:flex-row gap-1 mt-4">
                    <p class="block w-full font-fjalla text-right text-gray-700">{{ __('Courriel : ') }}</p>
                    <p class="block w-full font-fjalla">{{ $user->email }}</p>
                </div>

                <!-- Numéro de téléphone -->
                <div class="flex flex-col md:flex-row gap-1 mt-4">
                    <p class="block w-full font-fjalla text-right text-gray-700">{{ __('Numéro de téléphone : ') }}</p>
                    <p class="block w-full font-fjalla">{{ $user->numero_telephone }}</p>
                </div>

                <div class="flex justify-center mt-4">
                    <a href={{ route('indexUtilisateur') }} class="bg-dark-yellow px-6 py-1 rounded-md border border-gray-900 font-fjalla" type="submit">
                        {{ __('Retour') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
