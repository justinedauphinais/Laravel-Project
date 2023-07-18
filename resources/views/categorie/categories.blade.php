<!--/*****************************************************************************
 Fichier : catgories.blade.php
 Auteur : Jimmi Lancelot
 Fonctionnalité : la page des categories permet de lister toutes les categories,
                  on ajouter,supprimer, modifier et suspendre
 Date : 4/5/2023
*****************************************************************************/-->
<x-app-layout>
    <x-slot name="header">

    </x-slot>
                    {{--Barre de recherche des categories--}}
                    <div class="max-w-screen-md mx-auto mt-4 overflow-hidden border-2 border-red-800 rounded-lg drop-shadow-boite">
                        <div class="pt-3 pb-3 pr-3 text-center bg-white">
                            <h1 class="mb-6 text-2xl font-bold font-fjalla">{{__('Liste de categories')}}</h1>
                                <form method="get" action="{{ route('categories.search') }}">
                                    <input type="text" name="recherche" placeholder={{ __("Rechercher...") }}
                                        class="w-1/2 px-3 py-0 mr-4 border-2 border-black rounded-lg font-fjalla ">
                                    <button type="submit"
                                        class="w-1/2 mt-2 mr-4 font-bold text-black border border-black rounded-lg hover:bg-amber-400 bg-dark-yellow font-fjalla">{{__('Rechercher')}}
                                    </button>
                                </form>
                            </div>
                    </div>

                    <div id="divinfo" class="max-w-screen-md py-8 mx-auto mt-6 bg-white border-4 border-red-800 rounded-lg hide drop-shadow-boite">
                        <p id ="erreurs" class="text-center font-fjalla"></p>
                    </div>

                    @if(count($categories) == 0)
                        <div class="max-w-screen-md py-8 mx-auto mt-6 bg-white border-4 border-red-800 rounded-lg drop-shadow-boite">
                            <p class = "text-center font-fjalla">{{__('Aucune categorie trouver dans le base de donnée !')}}</p>
                        </div>
                    @else
                        @foreach ($categories as $categorie)
                            <div id="categorie-{{$categorie->id}}" class="container relative flex mx-auto mt-8 border-2 border-red-800 rounded-lg shadow-lg p-9 drop-shadow-boite <?php echo ($categorie->est_actif == 1) ? "bg-white hover:bg-gray-100" : "bg-red-200 hover:bg-red-300" ?>">

                                <p class="absolute left-0 ml-2 mr-4 text-lg font-bold font-fjalla top-4">{{__('ID:')}}
                                    <span id="idCategorie" class="px-2 py-1 rounded-xl bg-dark-yellow font-fjalla">
                                        {{ $categorie->id }}
                                    </span>
                                </p>
                                <p  class="absolute pl-2 pr-20 text-base font-bold border-r border-red-800 font-fjalla top-4 w-80 left-28">{{__('NOM:')}}
                                    <span id="nom-{{$categorie->id}}" class="text-gray-500 font-fjalla">
                                        {{ $categorie->nom }}
                                    </span>
                                </p>
                                <p  class="absolute w-5/12 pr-20 text-base font-bold border-r border-red-800 font-fjalla top-4 left-1/3">{{__('DESCRIPTION:')}}
                                    <span id="description-{{$categorie->id}}" class="text-gray-500 font-fjalla ">
                                        {{ $categorie->description }}
                                    </span>
                                </p>
                                <div class="absolute right-0 flex items-center top-3">
                                    <p class="mr-2 text-base font-bold font-fjalla">{{__('ACTION:')}}</p>
                                    <button type="submit"
                                        class="px-1 py-1 mr-1 font-bold text-black border border-black rounded-lg modifier font-fjalla hover:bg-amber-100 bg-pale-yellow"
                                        name="id" id="{{$categorie->id}}">{{__('Modifier')}}</button>

                                    <button id="{{$categorie->id}}"type="button"
                                        class="px-1 py-1 mr-1 font-bold text-black border border-black rounded-lg font-fjalla hover:bg-amber-100 bg-pale-yellow disable-category suspendreCategorie">
                                        @if($categorie->est_actif == 1)
                                            {{ __('Suspendre') }}
                                        @else
                                            {{ __('Réactiver') }}
                                        @endif
                                    </button>

                                    {{----}}
                                    {{--Bouton de la suppression de la categorie--}}
                                    <button id="{{$categorie->id}}"
                                        class="px-1 py-1 mr-4 font-bold text-black border border-black rounded-lg supprimerCategorie font-fjalla hover:bg-amber-400 bg-dark-yellow "
                                        name="id" >{{{ __('Supprimer')}}}</button>
                                </div>
                            </div>
                        @endforeach
                    @endif

        <div class="flex justify-end">
            <button id="btn-add-category" class="px-1 py-1 mt-6 font-bold text-black border border-black rounded-lg font-fjalla hover:bg-amber-300 bg-pale-yellow mr-72">{{{__('Ajouter une categorie')}}}</button>

        </div>

</x-app-layout>


