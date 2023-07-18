<!--/*****************************************************************************
Fichier : afficher-commentaire.balde.php
Auteur : Louis-Philippe Racette
Fonctionnalité : Affiche les commentaires
Date : 2023-05-07
*****************************************************************************/-->

<x-app-layout>
    @vite(['resources/js/commentaire.js'])
    <!--Mieu implémenter la gestion des erreurs-->
    @if ($errors->any())
        <div class="max-w-5xl bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mx-auto mt">
            <p>{{ __('Veuillez corriger l\'erreur ou les erreurs suivante(s)') }} :</p>
            <ul class="list-disc list-inside pl-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-4 border-dark-red drop-shadow-boite p-2">

                    <h2 class='text-center font-bold text-3xl my-2'>{{ $evenement->nom }}</h2>
                    @if (request()->routeIs('afficherCommentaireRechercheAdmin') or request()->routeIs('afficherCommentaireAdmin'))
                        <form action="{{ route('afficherCommentaireRechercheAdmin') }}" method="post" class="mb-4">
                        @else
                            <form action="{{ route('afficherCommentaireRecherche') }}" method="post" class="mb-4">
                    @endif

                    @csrf
                    <label for="contenu" class="font-bold">{{ __('Commentaires') }}</label>
                    <input type="text" name="contenu" id="contenu" class="rounded py-0 mx-2"
                        placeholder="{{ __('Filtrer par contenu') }}"">
                    <input class="border border-black rounded" type="hidden" name="id_evenement"
                        value="{{ $evenement->id }}">
                    <button class="bg-medium-yellow border border-black rounded px-4"
                        type="submit">{{ __('RECHERCHER') }}</button>
                    </form>

                    @if (isset($commentaires) and $commentaires != null and sizeof($commentaires) != 0)

                        @foreach ($commentaires as $commentaire)
                            <?php $user = $users[$commentaire['id_transaction_representation']];

                            ?>
                            <div class="grid grid-cols-5 p-2 rounded-lg border border-black mb-4">
                                <p class=" flex items-center border-gray-500 border-e-2 me-1 font-bold">
                                    {{ $user->prenom . ' ' . $user->nom }}</p>
                                <p class="col-span-3 break-words text-sm">{{ $commentaire->commentaire }}</p>
                                @if (request()->routeIs('afficherCommentaireRechercheAdmin') or request()->routeIs('afficherCommentaireAdmin'))
                                    <div class="flex flex-wrap items-center ms-auto">
                                        <input class="hide" value="{{ $commentaire->id }}"></input>
                                        @if ($commentaire->est_actif == 1)
                                            <button value="{{ $commentaire->est_actif }}"
                                                class="bg-pale-yellow rounded border border-black p-2 masquer">{{ __('MASQUER') }}</button>
                                        @else
                                            <button value="{{ $commentaire->est_actif }}"
                                                class="bg-red-400 rounded border border-black p-2 masquer">{{ __('MASQUER') }}</button>
                                        @endif

                                        <button value="{{ $commentaire->id }}"
                                            class="bg-pale-yellow rounded border border-black p-2 ms-2 supprimer_comm">{{ __('SUPPRIMER') }}</button>
                                    </div>
                                @else
                                    <a href="mailto:{{ $user->email }}"
                                        class="bg-pale-yellow w-40 h-10 my-auto ms-auto text-center leading-[2.5rem] rounded border border-black">{{ __('RÉPONDRE') }}</a>
                                @endif

                            </div>
                        @endforeach
                    @else
                        <p class="text-center font-bold">{{ __('Il n\'y a pas de commentaire!') }}</p>
                    @endif
                    <p></p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
