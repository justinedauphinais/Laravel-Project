<!--/*****************************************************************************
 Fichier : index.blade.php
 Auteur : Justine Dauphinais
 Fonctionnalité : Index des administrateurs pour les consulter, suspendre et supprimer
 Date : 28 avril 2023
*****************************************************************************/-->

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form method="get" action="{{ route('indexAdministrateur') }}"
                    class="p-2 drop-shadow-boite border-2 border-dark-red bg-white shadow sm:rounded-lg">
            @csrf
                <h1 class="text-3xl font-fjalla font-bold text-center w-full mb-3">{{__('Liste des administrateurs')}}</h1>
                <div class="w-full flex justify-around">
                    <div>
                        <label class="font-fjalla font-bold mr-2">{{__('Nom') . " : "}}</label>
                        <input class="font-fjalla h-6 rounded-md border-2 border-black" type="text"
                                name="nom"
                                placeholder="{{ __('Filtrer par nom') }}" />
                    </div>

                    <div class="flex flex-col">
                        <div class="mb-4">
                            <label class="font-fjalla font-bold mr-2">{{__('Prénom') . " : "}}</label>
                            <input class="font-fjalla h-6 rounded-md border-2 border-black" type="text"
                                    name="prenom"
                                    placeholder="{{ __('Filtrer par prénom') }}" />
                        </div>

                        <button class="uppercase font-fjalla font-bold bg-dark-yellow hover:bg-amber-400 px-2 rounded-lg border border-black mb-2">
                            {{__('Rechercher')}}
                        </button>
                    </div>

                    <div>
                        <div class="mb-5">
                            <label class="font-fjalla font-bold mr-2">{{__('Courriel') . " : "}}</label>
                            <input class="font-fjalla h-6 rounded-md border-2 border-black" type="text"
                                    name="email"
                                    placeholder="{{ __('Filtrer par courriel') }}" />
                        </div>

                        <a class="font-fjalla font-bold underline hover:text-dark-red" href={{ route('registerAdministrateur') }}>
                            {{__('Créer un administrateur')}}
                        </a>
                    </div>
                </div>
            </form>

            <div id="erreurAJAX" class="hide w-9/12 mx-auto my-4 text-center border-2 border-red-700 py-3 bg-red-200 rounded-md font-fjalla text-red-700">
                <p>{{ __("Une erreur est survenue.") }}</p>
                <p>{{ __('Veuillez réessayer plus tard.') }}</p>
            </div>

            <div id="confirmationSuppression" class="hide w-9/12 mx-auto my-4 text-center border-2 border-green-600 py-3 bg-green-100 rounded-md font-fjalla text-green-600">
                <p>{{ __('La suppression de l\'administrateur a fonctionné.') }}</p>
            </div>

            <div id="confirmationSuspension" class="hide w-9/12 mx-auto my-4 text-center border-2 border-green-600 py-3 bg-green-100 rounded-md font-fjalla text-green-600">
                <p>{{ __('La suspension de l\'administrateur a fonctionné.') }}</p>
            </div>

            <div id="confirmationReactivation" class="hide w-9/12 mx-auto my-4 text-center border-2 border-green-600 py-3 bg-green-100 rounded-md font-fjalla text-green-600">
                <p>{{ __('La réactivation de l\'administrateur a fonctionné.') }}</p>
            </div>

            @if (count($administrateurs) == 0)
                <div class="p-2 drop-shadow-boite border-2 border-dark-red bg-white shadow sm:rounded-lg text-center font-bold text-2xl font-fjalla">
                    {{ __('Il n\'y a aucun résultat!') }}
                </div>
            @else
                @foreach ($administrateurs as $admin)
                    <div id="div-{{ $admin->id }}" class="p-2 drop-shadow-boite border-2 border-dark-red shadow sm:rounded-lg flex justify-between <?php echo ($admin->est_actif == 1) ? "bg-white hover:bg-gray-100" : "bg-red-200 hover:bg-red-300" ?> ">
                        <a href={{ route('showAdministrateur', ['id' => $admin->id]) }} class="flex justify-between grow">
                            <div>
                                {{ __('ID') }}
                                <span class="rounded-xl bg-dark-yellow py-1 px-2 font-black" >
                                    {{ $admin->id }}
                                </span>
                            </div>
                            <div class="my-1 w-60">
                                <span class="font-bold font-fjalla">{{__('Nom complet : ')}}</span>
                                <span class="font-fjalla">{{ $admin->prenom . " " . $admin->nom }}</span>
                            </div>
                            <div class="my-1 w-60">
                                <span class="font-bold font-fjalla">{{__('Courriel : ')}}</span>
                                <span class="font-fjalla">{{ $admin->email }}</span>
                            </div>
                        </a>
                        <div>
                            <button id={{ $admin->id }} class="suspendre bg-pale-yellow hover:bg-amber-100 font-fjalla font-bold border border-black rounded-md w-40 uppercase py-1 mr-1 my-1">
                                @if ($admin->est_actif == 1)
                                    {{ __('Suspendre le compte') }}
                                @else
                                    {{ __('Réactiver le compte') }}
                                @endif
                            </button>
                            <button id={{ $admin->id }} class="supprimer bg-dark-yellow hover:bg-amber-400 font-fjalla font-bold border border-black rounded-md w-40 uppercase py-1 mr-1 my-1">
                                {{ __('Supprimer le compte') }}
                            </button>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>
