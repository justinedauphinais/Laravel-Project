<!--/*****************************************************************************
 Fichier : index.blade.php
 Auteur : Justine Dauphinais
 Fonctionnalité : Index des organisateurs pour les consulter, suspendre et supprimer
 Date : 28 avril 2023
*****************************************************************************/-->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form method="get" action="{{ route('indexOrganisateur') }}"
                    class="p-2 drop-shadow-boite border-2 border-dark-red bg-white shadow sm:rounded-lg">
            @csrf
                <h1 class="text-3xl font-fjalla font-bold text-center w-full mb-3">{{__('Liste des organisateurs')}}</h1>
                <div class="w-full flex justify-around">
                    <div>
                        <label class="font-fjalla font-bold mr-2">{{__('Nom') . " : "}}</label>
                        <input class="font-fjalla h-6 rounded-md border-2 border-black" type="text"
                                name="nom"
                                placeholder="{{ __('Filtrer par nom') }}" />
                    </div>

                    <div>
                        <label class="font-fjalla font-bold mr-2">{{__('Prénom') . " : "}}</label>
                        <input class="font-fjalla h-6 rounded-md border-2 border-black" type="text"
                                name="prenom"
                                placeholder="{{ __('Filtrer par prénom') }}" />
                    </div>

                    <div>
                        <label class="font-fjalla font-bold mr-2">{{__('Courriel') . " : "}}</label>
                        <input class="font-fjalla h-6 rounded-md border-2 border-black" type="text"
                                name="email"
                                placeholder="{{ __('Filtrer par courriel') }}" />
                    </div>

                    <div>
                        <div class="mb-5 ">
                            <label class="font-fjalla font-bold mr-2">{{__('Ville') . " : "}}</label>
                            <select name="ville" id="ville" class="font-fjalla py-0 h-6 rounded-md border-2 border-black" >
                                <option value="" class="hide" disabled selected>{{__('Filtrer par ville')}}</option>
                                <option value=0>{{ __('Aucune ville') }}</option>
                                @foreach ($villes as $ville)
                                    <option value={{ $ville->id }}>{{ $ville->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <button class="uppercase font-fjalla font-bold bg-dark-yellow hover:bg-amber-400 px-2 rounded-lg border w-60 border-black mb-2 m-auto block">
                    {{__('Rechercher')}}
                </button>
            </form>

            <div id="erreurAJAX" class="hide w-9/12 mx-auto my-4 text-center border-2 border-red-700 py-3 bg-red-200 rounded-md font-fjalla text-red-700">
                <p>{{ __("Une erreur est survenue.") }}</p>
                <p>{{ __('Veuillez réessayer plus tard.') }}</p>
            </div>

            <div id="confirmationSuppression" class="hide w-9/12 mx-auto my-4 text-center border-2 border-green-600 py-3 bg-green-100 rounded-md font-fjalla text-green-600">
                <p>{{ __('La suppression de l\'organisateur a fonctionné.') }}</p>
            </div>

            <div id="confirmationSuspension" class="hide w-9/12 mx-auto my-4 text-center border-2 border-green-600 py-3 bg-green-100 rounded-md font-fjalla text-green-600">
                <p>{{ __('La suspension de l\'organisateur a fonctionné.') }}</p>
            </div>

            <div id="confirmationReactivation" class="hide w-9/12 mx-auto my-4 text-center border-2 border-green-600 py-3 bg-green-100 rounded-md font-fjalla text-green-600">
                <p>{{ __('La réactivation de l\'organisateur a fonctionné.') }}</p>
            </div>

            @if (count($organisateurs) == 0)
                <div class="p-2 drop-shadow-boite border-2 border-dark-red bg-white shadow sm:rounded-lg text-center font-bold text-2xl font-fjalla">
                    {{ __('Il n\'y a aucun résultat!') }}
                </div>
            @else
                @foreach ($organisateurs as $organisateur)
                    <div id="div-{{ $organisateur->id }}" class="p-2 drop-shadow-boite border-2 border-dark-red shadow sm:rounded-lg flex justify-between <?php echo ($organisateur->est_actif == 1) ? "bg-white hover:bg-gray-100" : "bg-red-200 hover:bg-red-300" ?> ">
                        <div>
                            {{ __('ID') }}
                            <span class="rounded-xl bg-dark-yellow py-1 px-2 font-black" >
                                {{ $organisateur->id }}
                            </span>
                        </div>
                        <a href={{ route('showOrganisateur', ['id' => $organisateur->id]) }} class="w-96">
                            <div class="my-1 flex">
                                <p class="font-bold font-fjalla w-40 text-right mr-1">{{__('Nom complet : ')}}</p>
                                <p class="font-fjalla">{{ $organisateur->prenom . " " . $organisateur->nom }}</p>
                            </div>
                            <div class="my-1 flex">
                                <span class="font-bold font-fjalla w-40 text-right mr-1">{{__('Courriel : ')}}</span>
                                <span class="font-fjalla">{{ $organisateur->email }}</span>
                            </div>
                            <div class="my-1 flex">
                                <span class="font-bold font-fjalla w-40 text-right mr-1">{{__('Ville : ')}}</span>
                                <span class="font-fjalla">
                                    @if ($organisateur->ville == null)
                                        {{ __('Aucune ville') }}
                                    @else
                                        {{ $organisateur->ville->nom }}
                                    @endif
                                </span>
                            </div>
                            <div class="my-1 flex">
                                <span class="font-bold font-fjalla w-40 text-right mr-1">{{__('Numéro de téléphone : ')}}</span>
                                <span class="font-fjalla">{{ $organisateur->numero_telephone }}</span>
                            </div>
                        </a>
                        <div class="border-l-4 border-dark-red pl-2 w-96">
                            <h2 class="font-bold font-fjalla text-xl">{{__('Événements : ')}}<h2>
                            <?php $evenements = $organisateur->evenements; ?>
                            <div class="flex gap-1">
                                @foreach ($evenements as $evenement)
                                    <div>
                                        <img style="height: 75px; width: 75px;" src="{{ asset('img/evenementbase.jpg') }}" class="block rounded-md" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="border-l-4 border-dark-red pl-2 flex flex-col justify-between">
                            <h2 class="font-bold font-fjalla text-xl">{{__('Actions : ')}}<h2>
                            <div>
                                <button id={{ $organisateur->id }} class="suspendre bg-pale-yellow hover:bg-amber-100 font-fjalla font-bold border border-black rounded-md w-32 uppercase py-1 mr-1 my-1">
                                    @if ($organisateur->est_actif == 1)
                                        {{ __('Suspendre le compte') }}
                                    @else
                                        {{ __('Réactiver le compte') }}
                                    @endif
                                </button>
                                <button id={{ $organisateur->id }} class="supprimer bg-dark-yellow hover:bg-amber-400 font-fjalla font-bold border border-black rounded-md w-32 uppercase py-1 mr-1 my-1">
                                    {{ __('Supprimer le compte') }}
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>
