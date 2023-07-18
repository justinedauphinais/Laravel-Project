<?php

use App\Http\Controllers\EvenementController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategorieController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Middleware\EnsureUserIsUser;
use App\Http\Middleware\EnsureUserIsOrg;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::controller(ProfileController::class,)->group(function () {
    Route::post('/profile', 'update')->name('profile.update');
});

Route::controller(EvenementController::class)->group(function () {
    // affiche le formulaire pour creer un evenement
    Route::get('/formulaire/evenement', 'create')->name('formulaireEvenement')->middleware(EnsureUserIsOrg::class);
    Route::get('/formulaire-modif/evenement', 'edit')->name('formulaireModifEvenement')->middleware(EnsureUserIsOrg::class);
    Route::get('/admin/formulaire-modif/evenement', 'edit')->name('formulaireEvenementAdmin')->middleware(EnsureUserIsAdmin::class);
    Route::post('/ajouter/evenement', 'store')->name('ajouterEvenement')->middleware(EnsureUserIsOrg::class);
    Route::post('/modifier/evenement', 'update')->name('modifierEvenement')->middleware(EnsureUserIsOrg::class);
    Route::get('/evenements', 'index')->name('afficherEvenements')->middleware(EnsureUserIsOrg::class);
    Route::post('/supprimer/evenement', 'destroy')->name('supprimerEvenement')->middleware(EnsureUserIsOrg::class);
    Route::get('/admin/evenements', 'index')->name('afficherEvenementsAdmin')->middleware(EnsureUserIsAdmin::class);
    Route::get('/organisateur/evenements', 'index')->name('afficherEvenementsOrganisateur')->middleware(EnsureUserIsOrg::class);
});

Route::controller(CategorieController::class)->group(function() {
    Route::get('/categories', 'index')
            ->name('categories')
            ->middleware(EnsureUserIsAdmin::class);

    Route::get('/modification/categorie', 'edit')
            ->name('modificationCategorie')
            ->middleware(EnsureUserIsAdmin::class);

    Route::post('/suppression/categorie', 'destroy')
            ->name('suppressionCategorie')
            ->middleware(EnsureUserIsAdmin::class);

    Route::post('/enregistrementCategorie', 'update')
            ->name('enregistrementCategorie');
    Route::post('/suspension/categorie', 'destroy')
            ->name('suspensionCategorie')
            ->middleware(EnsureUserIsAdmin::class);

    Route::post('/categorie', 'store')
            ->name('ajouterCategorie')
            ->middleware(EnsureUserIsAdmin::class);

    Route::get('/categories/search', 'search')
            ->name('categories.search')
            ->middleware(EnsureUserIsAdmin::class);
});

Route::controller(UserController::class)->group(function () {
    Route::get('/administrateur', 'index')
        ->name('indexAdministrateur')
        ->middleware(EnsureUserIsAdmin::class);

    Route::get('/organisateur', 'index')
        ->name('indexOrganisateur')
        ->middleware(EnsureUserIsAdmin::class);

    Route::get('/utilisateur', 'index')
        ->name('indexUtilisateur')
        ->middleware(EnsureUserIsAdmin::class);

    Route::get('/administrateur/{id}', 'show')
        ->name('showAdministrateur')
        ->middleware(EnsureUserIsAdmin::class);

    Route::get('/organisateur/{id}', 'show')
        ->name('showOrganisateur')
        ->middleware(EnsureUserIsAdmin::class);

    Route::get('/utilisateur/{id}', 'show')
        ->name('showUtilisateur')
        ->middleware(EnsureUserIsAdmin::class);

    Route::get('/register/administrateur', 'create')
        ->name('registerAdministrateur')
        ->middleware(EnsureUserIsAdmin::class);

    Route::post('/register/administrateur', 'store')
        ->name('registerAdministrateurPost')
        ->middleware(EnsureUserIsAdmin::class);

    Route::get('/register/administrateur/{id}', 'show')
        ->name('confirmAdminRegister')
        ->middleware(EnsureUserIsAdmin::class);

    Route::post('/suspendre', 'destroy')
        ->name('suspendre');

    Route::post('/supprimer', 'destroy')
        ->name('supprimer');
});

Route::controller(CommentaireController::class)->group(function () {
    Route::get('/commentaire/afficher', 'index')->name('afficherCommentaire')->middleware(EnsureUserIsOrg::class);
    Route::post('/commentaire/afficher/recherche', 'index')->name('afficherCommentaireRecherche')->middleware(EnsureUserIsOrg::class);
    Route::get('/commentaire/afficher/recherche', 'index')->name('afficherCommentaireRecherche')->middleware(EnsureUserIsOrg::class);
    Route::get('/admin/commentaire/afficher', 'index')->name('afficherCommentaireAdmin')->middleware(EnsureUserIsAdmin::class);
    Route::post('/admin/commentaire/afficher/recherche', 'index')->name('afficherCommentaireRechercheAdmin')->middleware(EnsureUserIsAdmin::class);
    Route::get('/admin/commentaire/afficher/recherche', 'index')->name('afficherCommentaireRechercheAdmin')->middleware(EnsureUserIsAdmin::class);
});

require __DIR__ . '/auth.php';

