<!--/*****************************************************************************
Fichier : modif-consulter-evenement.blade.php
Auteurs : Matias Beaulieu
Fonctionnalité : S'occupe de l'affichage de l'événement et de son formulaire pour
                 le modifier
Date : 2023-04-30
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

    <div class="py-12 font-fjalla flex">
        <div class=" max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if (Session::has('succes'))
                <div role="alert">
                    <div id="message-event" class=" bg-white overflow-hidden shadow-sm rounded-lg border-4 border-dark-red drop-shadow-boite flex w-full mb-12">
                        <h1 class="text-3xl font-bold text-center py-3 text-green-400">{{ Session::get('succes') }}</h1>
                    </div>
                </div>
            @elseif (Session::has('erreur'))
                <div role="alert">
                    <div id="message-event" class=" bg-white overflow-hidden shadow-sm rounded-lg border-4 border-dark-red drop-shadow-boite flex w-full mb-12">
                        <h1 class="text-3xl font-bold text-center py-3 text-dark-red">{{ Session::get('erreur') }}</h1>
                    </div>
                </div>
            @endif
            <div class="affichage-event bg-white overflow-hidden shadow-sm rounded-lg border-4 border-dark-red drop-shadow-boite flex w-full mb-12">
                <div class="pb-6 text-gray-900 w-2/5">
                    <img src="{{ asset('img/evenementbase.jpg') }}" alt="" srcset="" class="rounded-tl-sm rounded-lg">
                    <h3 class="text-2xl font-bold py-9 pl-6 ">Nombre de billets restants</h3>
                    <div class="mx-6">
                        <?php
                            $rep_counter = 0;
                            $etats = array (
                                array ("EN VENTE", "bg-green-600"),
                                array ("COMPLET", "bg-blue-600"),
                                array ("TERMINÉ", "bg-red-500")
                            );
                        ?>
                        @foreach ($representations as $representation)
                            <?php
                                $billets_restants = $representation->nbr_places - $billets_vendus[$rep_counter];
                                $width = strval(round(($billets_vendus[$rep_counter] / $representation->nbr_places)*100));

                                if (time() > strtotime($representation->date." ".$representation->heure)) {
                                    $etat = $etats[2];
                                } elseif ($billets_restants == 0) {
                                    $etat = $etats[1];
                                } else {
                                    $etat = $etats[0];
                                }

                                $rep_counter += 1;
                            ?>
                            <div class="w-full flex items-center mb-4">
                                <div class="w-4/5 border-black border-2 rounded-lg">
                                    <div class="{{ $etat[1] }} h-8 rounded-md flex items-center" style="width :{{ $width }}%">
                                        <div class="ml-1 px-1 rounded-md bg-slate-50 max-w-fit max-h-fit inline absolute">
                                            Rep. {{ $rep_counter }} {{ $etat[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="min-w-fit w-1/5 pl-3 text-right">{{ $billets_restants }} / {{ $representation->nbr_places }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="p-12 pb-6 pt-6 text-gray-900 w-3/5">
                    <h1 class="text-5xl font-bold text-center pb-12">{{ $evenement->nom }}</h1>
                    <h2 class="text-4xl font-bold pb-12">{{ $evenement->lieu }}</h2>
                    @foreach ($representations as $representation)
                        <h2 class="text-3xl  pb-2">{{ date("l d F Y, H", strtotime($representation->date." ".$representation->heure)) }}h</h2>
                    @endforeach
                    <a href={{ $evenement->lien }} class="text-2xl py-9 text-blue-600 block underline">{{ __('Site Web informationnel') }}</a>
                    <form action="<?php echo (Auth::user()->id_role == 2 ? route('afficherCommentaire') : route('afficherCommentaireAdmin')) ?>" method="get">
                        <input type="hidden" name="id_evenement" value="{{ $evenement->id }}">
                        <button class="w-1/2 border rounded border-black bg-dark-yellow font-bold text-xl py-3 mt-3" type="submit">{{ __('Accéder aux commentaires') }}</button>
                    </form>
                </div>
            </div>
            <div class="affichage-event bg-white overflow-hidden shadow-sm rounded-lg border-4 border-dark-red drop-shadow-boite">
                <div class="p-12 pb-6 pt-6 text-gray-900">
                    <form action="{{ route('modifierEvenement') }}" method="post">
                        @csrf
                        <fieldset>
                            <legend class="text-2xl font-bold text-center pb-4">{{ __('Modifier l\'événement') }}</legend>

                            <div class="grid grid-cols-6 gap-2 gap-y-6">

                                <!-- Premiere range -->

                                <div class="flex flex-col justify-center items-start">
                                    <label for="titre">{{ __('Titre:') }}</label>
                                </div>
                                <div>
                                    <input {{ (Auth::user()->id_role == 1) ? "disabled" : ""  }}
                                        class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        type="text" name="titre" id="titre" value="{{ $evenement->nom }}">
                                </div>
                                <div class="flex flex-col justify-center items-start">
                                    <label for="etat">{{ __('Statut:') }}</label>
                                </div>
                                <div>
                                    <select {{ (Auth::user()->id_role == 1) ? "disabled" : ""  }}
                                        class="block appearance-none w-full bg-white border text-gray-700 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 pl-2"
                                        id="etat" name="etat">
                                        @foreach ($statuts as $statut)
                                            <option value="{{ $statut->id }}"
                                                @if ($statut->id == $evenement->statut->id) {{ 'selected' }} @endif>
                                                {{ $statut->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex flex-col justify-center items-start">
                                    <label for="code_postal">{{ __('Code postal:') }}</label>
                                </div>
                                <div>
                                    <input {{ (Auth::user()->id_role == 1) ? "disabled" : ""  }}
                                        class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        type="text" name="code_postal" id="code_postal"
                                        value="{{ $evenement->code_postal }}">
                                </div>

                                <!-- Deuxieme range -->

                                <div class="flex flex-col justify-center items-start">
                                    <label for="adresse">{{ __('Lieu:') }}</label>
                                </div>
                                <div>
                                    <input {{ (Auth::user()->id_role == 1) ? "disabled" : ""  }}
                                        class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        type="text" name="adresse" id="adresse" value="{{ $evenement->lieu }}">
                                </div>
                                <div class="flex flex-col justify-center items-start">
                                    <label for="lien">{{ __('Lien:') }}</label>
                                </div>
                                <div>
                                    <input {{ (Auth::user()->id_role == 1) ? "disabled" : ""  }}
                                        class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        type="text" name="lien" id="lien" value="{{ $evenement->lien }}">
                                </div>
                                <div class="flex flex-col justify-center items-start">
                                    <label for="ville">{{ __('Ville:') }}</label>
                                </div>
                                <div>
                                    <select {{ (Auth::user()->id_role == 1) ? "disabled" : ""  }}
                                        class="block appearance-none w-full bg-white border text-gray-700 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 pl-2"
                                        id="ville" name="ville">
                                        @foreach ($villes as $ville)
                                            <option value="{{ $ville->id }}"
                                                @if ($ville->id == $evenement->ville->id) {{ 'selected' }} @endif>
                                                {{ $ville->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Troisième range -->

                                <div class="flex flex-col justify-center items-start">
                                    <label for="pays">{{ __('Pays:') }}</label>
                                </div>
                                <div>
                                    <select {{ (Auth::user()->id_role == 1) ? "disabled" : ""  }}
                                        class="block appearance-none w-full bg-white border text-gray-700 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 pl-2"
                                        id="pays" name="pays">

                                        @foreach ($pays as $country)
                                            <option value="{{ $country->id }}"
                                                @if ($country->id == $evenement->pays($evenement->ville->id)[0]->id) {{ 'selected' }} @endif>
                                                {{ $country->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex flex-col justify-center items-start">
                                    <label for="categorie">{{ __('Catégorie:') }}</label>
                                </div>
                                <div>
                                    <select {{ (Auth::user()->id_role == 1) ? "disabled" : ""  }}
                                        class="block appearance-none w-full bg-white border text-gray-700 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 pl-2"
                                        id="categorie" name="categorie">
                                        @foreach ($categories as $categorie)
                                            <option value="{{ $categorie->id }}"
                                                @if ($categorie->id == $evenement->categorie->id) {{ 'selected' }} @endif>
                                                {{ $categorie->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex flex-col justify-center items-start">
                                    <label for="prix_billet">{{ __('Prix billet:') }}</label>
                                </div>
                                <div>
                                    <input {{ (Auth::user()->id_role == 1) ? "disabled" : ""  }}
                                        class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        type="text" name="prix_billet" id="prix_billet"
                                        value="{{ count($representations) ? $representations[0]->prix : "" }}">
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
                                    <input class="border rounded py-1 w-full pl-2" type="datetime-local" name="date1" {{ (Auth::user()->id_role == 1) ? "disabled" : ""  }}
                                        id="date1" value="{{ count($representations) >= 1 ? $representations[0]->date . "T" . date("H:m", strtotime($representations[0]->heure)) : "" }}">
                                </div>
                                <div class="flex flex-col justify-center items-start">
                                    <label for="date2">{{ __('Date 2:') }}</label>
                                </div>
                                <div>
                                    <input class="border rounded py-1 w-full pl-2" type="datetime-local" name="date2" {{ (Auth::user()->id_role == 1) ? "disabled" : ""  }}
                                        id="date2" value="{{ count($representations) >= 2 ? $representations[1]->date . "T" . date("H:m", strtotime($representations[1]->heure)) : "" }}">
                                </div>
                                <div class="flex flex-col justify-center items-start">
                                    <label for="date3">{{ __('Date 3:') }}</label>
                                </div>
                                <div>
                                    <input class="border rounded py-1 w-full pl-2" type="datetime-local" name="date3" {{ (Auth::user()->id_role == 1) ? "disabled" : ""  }}
                                        id="date3" value="{{ count($representations) >= 3 ? $representations[2]->date . "T" . date("H:m", strtotime($representations[2]->heure)) : "" }}">
                                </div>

                                <!-- Deuxieme range -->

                                <div class="flex flex-col justify-center items-start">
                                    <label for="nombre_billet1">{{ __('Nombre de billet:') }}</label>
                                </div>
                                <div>
                                    <input {{ (Auth::user()->id_role == 1) ? "disabled" : ""  }}
                                        class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        type="text" name="nombre_billet1" id="nombre_billet1"
                                        value="{{ count($representations) >= 1 ? $representations[0]->nbr_places : "" }}">
                                </div>
                                <div class="flex flex-col justify-center items-start">
                                    <label for="nombre_billet2">{{ __('Nombre de billet:') }}</label>
                                </div>
                                <div>
                                    <input {{ (Auth::user()->id_role == 1) ? "disabled" : ""  }}
                                        class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        type="text" name="nombre_billet2" id="nombre_billet2"
                                        value="{{ count($representations) >= 2 ? $representations[1]->nbr_places : "" }}">
                                </div>
                                <div class="flex flex-col justify-center items-start">
                                    <label for="nombre_billet3">{{ __('Nombre de billet:') }}</label>
                                </div>
                                <div>
                                    <input {{ (Auth::user()->id_role == 1) ? "disabled" : ""  }}
                                        class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        type="text" name="nombre_billet3" id="nombre_billet3"
                                        value="{{ count($representations) >= 3 ? $representations[2]->nbr_places : "" }}">
                                </div>

                                <!-- Troisième range -->

                                <div class="col-span-2">
                                    <input type="checkbox" name="representation_active1" id="representation_active1" {{ (Auth::user()->id_role == 1) ? "disabled" : ""  }}
                                        class="me-1 <?= (Auth::user()->id_role == 1) ? "checked:bg-gray-400 hover:bg-gray-400" : "" ?>" {{ (count($representations) >= 1 ? $representations[0]->est_actif : "") == '1' ? 'checked' : '' }}>
                                    <label class="text-sm"
                                        for="representation_active1">{{ __('représentation active') }}</label>
                                </div>

                                <div class="col-span-2">
                                    <input type="checkbox" name="representation_active2" id="representation_active2" {{ (Auth::user()->id_role == 1) ? "disabled" : ""  }}
                                        class="me-1 <?= (Auth::user()->id_role == 1) ? "checked:bg-gray-400 hover:bg-gray-400" : "" ?>" {{ (count($representations) >= 2 ? $representations[1]->est_actif : "") == '1' ? 'checked' : '' }}>
                                    <label class="text-sm"
                                        for="representation_active2">{{ __('représentation active') }}</label>
                                </div>

                                <div class="col-span-2">
                                    <input type="checkbox" name="representation_active3" id="representation_active3" {{ (Auth::user()->id_role == 1) ? "disabled" : ""  }}
                                        class="me-1 <?= (Auth::user()->id_role == 1) ? "checked:bg-gray-400 hover:bg-gray-400" : "" ?>" {{ (count($representations) >= 3 ? $representations[2]->est_actif : "") == '1' ? 'checked' : '' }}>
                                    <label class="text-sm"
                                        for="representation_active3">{{ __('représentation active') }}</label>
                                </div>
                            </div>
                        </fieldset>
                        <input type="hidden" name="id_evenement" value="{{ $evenement->id }}">
                        <input type="hidden" name="id_representation1" value="{{ count($representations) >= 1 ? $representations[0]->id : 0 }}">
                        <input type="hidden" name="id_representation2" value="{{ count($representations) >= 2 ? $representations[1]->id : 0 }}">
                        <input type="hidden" name="id_representation3" value="{{ count($representations) >= 3 ? $representations[2]->id : 0 }}">

                        @if (Auth::user()->id_role == 2)
                            <div class="flex flex-row justify-center item-center mt-8">
                                <a href="{{ route('afficherEvenementsOrganisateur') }}"
                                    class="w-1/6 border rounded border-black bg-pale-yellow text-center font-bold">{{ __('Annuler') }}</a>
                                <button class="w-1/6 border mx-12 rounded border-black bg-medium-yellow font-bold"
                                    type="reset">{{ __('Réinitialiser') }}</button>
                                <button class="w-1/6 border rounded border-black bg-dark-yellow font-bold"
                                    type="submit">{{ __('Modifier') }}</button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
            @if (Auth::user()->id_role == 2)
                <div class="affichage-event w-full">
                    <div class="flex w-full">
                        <button id="supprimerEvent" class="mx-auto w-1/4 border rounded border-black bg-dark-red font-bold text-xl py-3 mt-12 text-white">{{ __('Supprimer') }}</button>
                    </div>
                    <form action="{{ route('supprimerEvenement') }}" method="post" class="flex w-full">
                        @csrf
                        <button name="id_evenement" value="{{ $evenement->id }}" id="confirmerSupprimerEvent" class="mx-auto w-1/4 border rounded border-black bg-dark-red font-bold text-xl py-3 mt-12 text-white hide" type="submit">{{ __('Êtes-vous certain?') }}</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
