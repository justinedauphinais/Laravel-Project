<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BilletController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\VilleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategorieController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\EnsureUserIsUser;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(TransactionController::class)->group(function () {
    Route::post('/transaction/insertion', 'store')->name('transactionInsertionApi')->middleware(['auth:sanctum', EnsureUserIsUser::class]);
    Route::post('/transaction/update', 'update')->name('transactionUpdateApi')->middleware(['auth:sanctum', EnsureUserIsUser::class]);
});

Route::controller(BilletController::class)->group(function () {
    Route::get('/billets/user', 'index')->name('billetsUserApi')->middleware(['auth:sanctum', EnsureUserIsUser::class]);
    Route::post('/billet/update', 'update')->name('billetUpdateApi')->middleware(['auth:sanctum', EnsureUserIsUser::class]);
});

Route::controller(CommentaireController::class)->group(function () {
    Route::post('/commentaire/ajouter', 'store')->name('ajouterCommentaireApi')->middleware(['auth:sanctum', EnsureUserIsUser::class]);
    Route::post('/commentaire/modifier', 'update')->name('updateCommentaireApi')->middleware(['auth:sanctum', EnsureUserIsUser::class]);
    Route::post('/commentaire/supprimer', 'destroy')->name('supprimerCommentaire')->middleware(['auth:sanctum', EnsureUserIsUser::class]);
    Route::post('/commentaire/activer', 'update')->name('activerCommentaire')->middleware(['auth:sanctum', EnsureUserIsUser::class]);
    Route::get('/commentaire/commentaires', 'index')->name('commentaires')->middleware(['auth:sanctum', EnsureUserIsUser::class]);
});

Route::controller(CategorieController::class)->group(function() {
    Route::get('/categories','index')->name('LstCategoriesApi')->middleware(['auth:sanctum', EnsureUserIsUser::class]);
    Route::get('/categorie/{id}', 'show')->name('categorieApi')->middleware(['auth:sanctum', EnsureUserIsUser::class]);
    Route::post('/insertion/categorie', 'store')->name('insertionCategorieApi')->middleware(['auth:sanctum',EnsureUserIsAdmin::class]);
    Route::delete('/supprimer/categorie/{id}', 'destroy')->name('suppressionCategorieApi')->middleware(['auth:sanctum',EnsureUserIsAdmin::class]);
    Route::put('/modifier/categorie/{id}', 'update')->name('modificationCategorieApi')->middleware(['auth:sanctum',EnsureUserIsAdmin::class]);
    Route::put('suspendue/categories/{categorie}/toggle','destroy')->name('suspenssionCategorieApi')->middleware(['auth:sanctum',EnsureUserIsAdmin::class]);
});

Route::controller(EvenementController::class)->group(function () {
    Route::get('/evenements', 'show')->name('evenementsApi')->middleware(['auth:sanctum', EnsureUserIsUser::class]);
    Route::get('/evenement/{id}', 'show')->name('evenementApi')->middleware(['auth:sanctum', EnsureUserIsUser::class]);
});

Route::post('/loginAPI', [AuthenticatedSessionController::class, 'loginApi'])->name("loginApi");

Route::post('/token', [UserController::class, 'token'])->name('token');
Route::get('/user/{id}', [UserController::class, 'show'])->name('getUserApi')->middleware(['auth:sanctum', EnsureUserIsUser::class]);
Route::post('/addUser', [UserController::class, 'store'])->name('storeApi');
Route::post('/user/modify/{id}', [ProfileController::class, 'updateAPI'])->name('modifyUserApi')->middleware(['auth:sanctum', EnsureUserIsUser::class]);

Route::get('/villes', [VilleController::class, 'index']);
