<!--/*****************************************************************************
 Fichier : navigation.blade.php
 Auteur : Justine Dauphinais
 Fonctionnalité : Barre de navigation du site web
 Date : 27 avril 2023
*****************************************************************************/-->
<?php
    setlocale(LC_TIME, "fr_Fr");
    date_default_timezone_set('America/New_York');
    $date = ucfirst(strftime('%A %d %B %Y'));
?>

<p class="ml-10 mr-11 mt-2 w-12/12 text-right font-bold font-fjalla text-white"><?= $date ?></p>
<nav x-data="{ open: false }"
    class="bg-white border-2 border-dark-red mx-10 mt-2 rounded-xl drop-shadow-boite z-50 relative">
    <!-- Primary Navigation Menu -->

    <div class="mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between h-16">
            <div class="flex justify-between w-full">
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('dashboard') }}">

                        <img src="{{ asset('img/logo.png') }}" class="block h-12 mr-3" />

                    </a>
                    <?php if (Auth::check()) { ?>
                        <?php if (Auth::user()->id_role == 1) {?>
                            <h2 class="text-dark-red font-fjalla font-extrabold text-sm py-2 pl-3 border-l-2 border-dark-red uppercase">
                                {{ __('Administrateur') }}
                            </h2>
                        <?php } else if (Auth::user()->id_role == 2) { ?>
                            <h2 class="text-dark-red font-fjalla font-extrabold text-sm py-2 pl-3 border-l-2 border-dark-red uppercase">
                                {{ __('Organisateur') }}
                            </h2>
                        <?php } else if (Auth::user()->id_role == 3) { ?>
                            <h2 class="text-dark-red font-fjalla font-extrabold text-sm py-2 pl-3 border-l-2 border-dark-red uppercase">
                                {{ __('Utilisateur') }}</h2>
                        <?php } ?>
                    <?php } else {?>
                        <h2 class="text-dark-red font-fjalla font-extrabold text-sm py-2 pl-3 border-l-2 border-dark-red uppercase">
                            {{ __('Invité') }}
                        </h2>
                    <?php } ?>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 xl:flex xl:items-center">
                    <?php if (Auth::check()) { ?>
                        <a href={{ route('dashboard') }}
                            class="font-fjalla font-bold hover:text-dark-red <?= request()->routeIs('dashboard') ? 'underline decoration-2' : '' ?>">
                            {{ __('Accueil') }}
                        </a>
                        <?php if (Auth::user()->id_role == 1) { ?>
                            <!--Admin-->
                            <a href={{ route('afficherEvenementsAdmin') }}
                                class="font-fjalla font-bold hover:text-dark-red <?= str_contains(url()->full(), "evenement") ? 'underline decoration-2' : '' ?>">
                                {{ __('Événements') }}
                            </a>
                            <a href={{ route('indexAdministrateur') }}
                                class="font-fjalla font-bold hover:text-dark-red <?= str_contains(url()->full(), "administrateur") ? 'underline decoration-2' : '' ?>">
                                {{ __('Administrateurs') }}
                            </a>
                            <a href={{ route('categories') }}
                                class="font-fjalla font-bold hover:text-dark-red <?= str_contains(url()->full(), "categorie") ? 'underline decoration-2' : '' ?>">
                                {{ __('Catégories') }}
                            </a>
                            <a href={{ route('indexUtilisateur') }}
                                class="font-fjalla font-bold hover:text-dark-red <?= str_contains(url()->full(), "utilisateur") ? 'underline decoration-2' : '' ?>">
                                {{ __('Utilisateurs') }}
                            </a>
                            <a href={{ route('indexOrganisateur') }}
                                class="font-fjalla font-bold hover:text-dark-red <?= str_contains(url()->full(), "organisateur") ? 'underline decoration-2' : '' ?>">
                                {{ __('Organisateurs') }}
                            </a>
                        <?php } else if (Auth::user()->id_role == 2) { ?>
                        <!--Organisateur-->
                        <a href={{ route('afficherEvenementsOrganisateur') }}
                            class="font-fjalla font-bold hover:text-dark-red <?= str_contains(url()->full(), "evenement") ? 'underline decoration-2' : '' ?>">
                            {{ __('Mes événements') }}
                        </a>
                        <?php } ?>
                    <?php } ?>
                    <div>
                        <x-dropdown>
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center z-40 pr-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div
                                        class="font-fjalla font-bold text-black text-base hover:text-dark-red <?= request()->routeIs('profile') ? 'underline decoration-2' : '' ?>">
                                        {{ __('Mon profil') }}
                                    </div>

                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>


                            <x-slot name="content">
                                <div class="block p-1 flex flex-col gap-1">
                                    <!-- Authentication -->
                                    <?php if (Auth::check()) { ?>
                                        <a href={{ route('profile.edit') }} class="<?= str_contains(url()->full(), "profile") ? 'bg-pale-yellow' : 'bg-dark-yellow' ?> hover:bg-amber-400 text-center m-auto w-full py-1 block rounded-md font-fjalla font-bold border border-black">
                                            {{ __('Profile') }}
                                        </a>

                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf

                                            <a href={{ route('logout') }} class="<?= str_contains(url()->full(), "profile") ? 'bg-pale-yellow' : 'bg-dark-yellow' ?> hover:bg-amber-400 text-center m-auto w-full py-1 block rounded-md font-fjalla font-bold border border-black"
                                                onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                                {{ __('Déconnexion') }}
                                            </a>
                                        </form>
                                    <?php } else { ?>
                                        <a href={{ route('registerOrganisateur') }} class="<?= str_contains(url()->full(), "register") ? 'bg-pale-yellow' : 'bg-dark-yellow' ?> hover:bg-amber-400 text-center m-auto w-full py-1 block rounded-md font-fjalla font-bold border border-black">
                                            {{ __('S\'inscrire') }}
                                        </a>
                                        <a href={{ route('login') }} class="<?= str_contains(url()->full(), "login") ? 'bg-pale-yellow' : 'bg-dark-yellow' ?> hover:bg-amber-400 text-center m-auto w-full py-1 block rounded-md font-fjalla font-bold border border-black">
                                            {{ __('Se connecter') }}
                                        </a>
                                    <?php } ?>
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>

                <div class="xl:hidden space-x-8 flex items-center">
                    <x-dropdown>
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center z-40 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div class="text-black text-base hover:text-dark-red <?= request()->routeIs('profile') ? 'underline decoration-2' : '' ?>">
                                    <i id="hamburger" class="fa-solid fa-bars fa-xl rotate"></i>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="block p-1 flex flex-col gap-1">
                                <?php if (Auth::check()) { ?>
                                    <a href={{ route('dashboard') }} class="<?= str_contains(url()->full(), "dashboard") ? 'bg-pale-yellow' : 'bg-dark-yellow' ?> hover:bg-amber-400 text-center m-auto w-full py-1 block rounded-md font-fjalla font-bold border border-black">
                                        {{ __('Accueil') }}
                                    </a>
                                    <?php if (Auth::user()->id_role == 1) { ?>
                                        <!--Admin-->
                                        <a href={{ route('afficherEvenementsAdmin') }} class="<?= str_contains(url()->full(), "evenement") ? 'bg-pale-yellow' : 'bg-dark-yellow' ?> hover:bg-amber-400 text-center m-auto w-full py-1 block rounded-md font-fjalla font-bold border border-black">
                                            {{ __('Événements') }}
                                        </a>
                                        <a href={{ route('indexAdministrateur') }} class="<?= str_contains(url()->full(), "administrateur") ? 'bg-pale-yellow' : 'bg-dark-yellow' ?> hover:bg-amber-400 text-center m-auto w-full py-1 block rounded-md font-fjalla font-bold border border-black">
                                            {{ __('Administrateurs') }}
                                        </a>
                                        <a href={{ route('categories') }} class="<?= str_contains(url()->full(), "categorie") ? 'bg-pale-yellow' : 'bg-dark-yellow' ?> hover:bg-amber-400 text-center m-auto w-full py-1 block rounded-md font-fjalla font-bold border border-black">
                                            {{ __('Catégories') }}
                                        </a>
                                        <a href={{ route('indexUtilisateur') }} class="<?= str_contains(url()->full(), "utilisateur") ? 'bg-pale-yellow' : 'bg-dark-yellow' ?> hover:bg-amber-400 text-center m-auto w-full py-1 block rounded-md font-fjalla font-bold border border-black">
                                            {{ __('Utilisateurs') }}
                                        </a>
                                        <a href={{ route('indexOrganisateur') }} class="<?= str_contains(url()->full(), "organisateur") ? 'bg-pale-yellow' : 'bg-dark-yellow' ?> hover:bg-amber-400 text-center m-auto w-full py-1 block rounded-md font-fjalla font-bold border border-black">
                                            {{ __('Organisateurs') }}
                                        </a>
                                    <?php } else if (Auth::user()->id_role == 2) { ?>
                                    <!--Organisateur-->
                                    <a href={{ route('afficherEvenementsOrganisateur') }} class="<?= str_contains(url()->full(), "evenement") ? 'bg-pale-yellow' : 'bg-dark-yellow' ?> hover:bg-amber-400 text-center m-auto w-full py-1 block rounded-md font-fjalla font-bold border border-black">
                                        {{ __('Mes événements') }}
                                    </a>
                                    <?php } ?>

                                    <a href={{ route('profile.edit') }} class="<?= str_contains(url()->full(), "profile") ? 'bg-pale-yellow' : 'bg-dark-yellow' ?> hover:bg-amber-400 text-center m-auto w-full py-1 block rounded-md font-fjalla font-bold border border-black">
                                        {{ __('Profile') }}
                                    </a>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <a href={{ route('logout') }} class="<?= str_contains(url()->full(), "profile") ? 'bg-pale-yellow' : 'bg-dark-yellow' ?> hover:bg-amber-400 text-center m-auto w-full py-1 block rounded-md font-fjalla font-bold border border-black"
                                            onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                            {{ __('Déconnexion') }}
                                        </a>
                                    </form>
                                <?php } else { ?>
                                    <a href={{ route('registerOrganisateur') }} class="<?= str_contains(url()->full(), "register") ? 'bg-pale-yellow' : 'bg-dark-yellow' ?> hover:bg-amber-400 text-center m-auto w-full py-1 block rounded-md font-fjalla font-bold border border-black">
                                        {{ __('S\'inscrire') }}
                                    </a>
                                    <a href={{ route('login') }} class="<?= str_contains(url()->full(), "login") ? 'bg-pale-yellow' : 'bg-dark-yellow' ?> hover:bg-amber-400 text-center m-auto w-full py-1 block rounded-md font-fjalla font-bold border border-black">
                                        {{ __('Se connecter') }}
                                    </a>
                                <?php } ?>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </div>
    </div>
</nav>
