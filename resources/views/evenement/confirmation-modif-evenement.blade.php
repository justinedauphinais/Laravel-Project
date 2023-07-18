<!--/*****************************************************************************
Fichier : confirmation-modif-evenement.blade.php
Auteur : Matias Beaulieu
Fonctionnalité : Affiche la confirmation que l'événement est modifié
Date : 2023-05-04
*****************************************************************************/-->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Confirmation de la création de l\'événement') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-12 pb-6 pt-6 text-gray-900 text-center">
                    <p class="pt-2 pb-2">{{ __('Votre événement:') }} <span class="font-bold">{{ $titre }}</span>
                        {{ __('a été modifié avec succès!') }}</p>
                    <p class=" pb-2">{{ __('Voici les informations:') }}</p>
                    <p>
                        {{ __('Titre:') }} <span class="font-bold">{{ $titre }}</span>
                    </p>
                    <p>
                        {{ __('État:') }} <span class="font-bold">{{ $etat }}</span>
                    </p>
                    <p>
                        {{ __('Code postal:') }} <span class="font-bold">{{ $code_postal }}</span>
                    </p>

                    <p>
                        {{ __('Adresse avec la rue:') }} <span class="font-bold">{{ $adresse }}</span>
                    </p>
                    <p>
                        {{ __('Lien:') }} <span class="font-bold">{{ $lien }}</span>
                    </p>
                    <p>
                        {{ __('Ville:') }} <span class="font-bold">{{ $ville }}</span>
                    </p>




                    <p>
                        {{ __('Pays:') }} <span class="font-bold">{{ $pays }}
                    </p>
                    <p>
                        {{ __('Catégorie:') }} <span class="font-bold">{{ $categorie }}
                    </p>
                    <p>
                        {{ __('Prix billet:') }} <span class="font-bold">{{ $prix_billet }}
                    </p>

                    <p class="pt-4 pb-2">
                        {{ __('Voici les informations pour les représentation(s):') }}
                    </p>

                    <p>
                        {{ __('Date 1:') }} <span class="font-bold">{{ $date1 }}</span>
                    </p>
                    <p>
                        {{ __('Nombre de billet:') }} <span class="font-bold">{{ $representation1 }}</span>
                    </p>
                    <p>
                        {{ __('Est actif:') }} <span class="font-bold">{{ $actif1 }}</span>
                    </p>


                    @if ($date2)
                        <p>
                            {{ __('Date 2:') }} <span class="font-bold">{{ $date2 }}</span>
                        </p>
                        <p>
                            {{ __('Nombre de billet:') }} <span class="font-bold">{{ $representation2 }}</span>
                        </p>
                        <p>
                            {{ __('Est actif:') }} <span class="font-bold">{{ $actif2 }}</span>
                        </p>
                    @endif
                    @if ($date3)
                        <p>
                            {{ __('Date 3:') }} <span class="font-bold">{{ $date3 }}</span>
                        </p>
                        <p>
                            {{ __('Nombre de billet:') }} <span class="font-bold">{{ $representation3 }}</span>
                        </p>
                        <p>
                            {{ __('Est actif:') }} <span class="font-bold">{{ $actif3 }}</span>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
