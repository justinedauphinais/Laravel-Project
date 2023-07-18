<?php namespace App\Http\Controllers\Auth;

/*****************************************************************************
 Fichier : UserController.php
 Auteur : Justine Dauphinais
 Fonctionnalité : Permet la gestion des utilisateurs
 Date : 26 avril 2023
*****************************************************************************/

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Ville;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $utilisateurs = User::All();
        $utilisateursValide = [];

        $roles = Role::All();
        $roleVoulu = ucfirst($request->path());
        $roleId = 0;
        foreach ($roles as $role) {
            if ($role->nom == $roleVoulu) {
                $roleId = $role->id;
            }
        }

        if ($request->has('nom'))
            $nom = $request->nom;
        if ($request->has('prenom'))
            $prenom = $request->prenom;
        if ($request->has('email'))
            $email = $request->email;
        if ($request->has('ville'))
            $ville = $request->ville;

        foreach ($utilisateurs as $utilisateur) {
            $filtrer = True;

            if ($utilisateur->id_role == $roleId) {
                if (isset($nom)) {
                    if (!str_contains($utilisateur->nom, $nom))
                        $filtrer = False;
                }

                if (isset($prenom))
                    if (!str_contains($utilisateur->prenom, $prenom)) {
                        $filtrer = False;
                }

                if (isset($ville)) {
                    if ($ville == 0) {
                        if ($utilisateur->id_ville != null)
                            $filtrer = False;
                    }
                    else {
                        if ($utilisateur->id_ville != $ville)
                            $filtrer = False;
                    }
                }

                if (isset($email)) {
                    if (!str_contains($utilisateur->email, $email))
                        $filtrer = False;
                }

                if ($filtrer)
                    array_push($utilisateursValide, $utilisateur);
            }
        }

        if ($request->routeIs('indexAdministrateur')) {
            return view('administrateur.index', [
                'administrateurs' => $utilisateursValide
            ]);
        }
        else if ($request->routeIs('indexOrganisateur')) {
            return view('organisateur.index', [
                'organisateurs' => $utilisateursValide,
                'villes' => Ville::All()
            ]);
        }
        else if ($request->routeIs('indexUtilisateur')) {
            return view('utilisateur.index', [
                'utilisateurs' => $utilisateursValide,
                'villes' => Ville::All()
            ]);
        }
    }

    public function show(Request $request, int $id = 0)
    {
        $user = User::find($id);

        if ($request->routeIs("confirmAdminRegister")) {
            return view('administrateur.confirmAdminRegister', [
                'user' => $user
            ]);
        }
        else if ($request->routeIs("showAdministrateur")) {
            return view('administrateur.show', [
                'user' => $user
            ]);
        }
        else if ($request->routeIs("showOrganisateur")) {
            return view('organisateur.show', [
                'user' => $user
            ]);
        }
        else if ($request->routeIs("showUtilisateur")) {
            return view('utilisateur.show', [
                'user' => $user
            ]);
        }
        else {
            if (empty($user))
                return response()->json(['ERREUR' => __('L\'utilisateur demandé est introuvable.')], 400);

            return new UserResource($user);
        }
    }

    public function token(Request $request) {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'mot_de_passe' => 'required',
            'nom_token' => 'required'
        ], [
            'email.required' => __('Veuillez entrer le courriel de l\'utilisateur.'),
            'email.email' => __('Le courriel de l\'utilisateur doit être valide.'),
            'mot_de_passe.required' => __('Veuillez entrer le mot de passe de l\'utilisateur.'),
            'nom_token.required' => __('Veuillez inscrire le nom souhaité pour le token.')
        ]);

        if ($validation->fails())
            return response()->json(['ERREUR' => $validation->errors()], 400);

        $contenuDecode = $validation->validated();
        $utilisateur = User::where('email', '=', $contenuDecode['email'])->first();

        if (($utilisateur === null) || !Hash::check($contenuDecode['mot_de_passe'], $utilisateur->password))
            return response()->json(['ERREUR' => __('Informations d\'authentification invalides')], 500);

        return response()->json(
            ['SUCCES' => $utilisateur->createToken($contenuDecode['nom_token'])->plainTextToken], 200
        );
    }


    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        if ($request->routeIs('registerAdministrateur')) {
            return view('administrateur.registerAdmin');
        }
        else if ($request->routeIs('registerOrganisateur')) {
            return view('organisateur.registerOrganisateur', [
                'villes' => Ville::All()
            ]);
        }
        else if ($request->routeIs('registerUtilisateur')) {
            return view('utilisateur.registerUtilisateur', [
                'villes' => Ville::All()
            ]);
        }
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        if ($request->routeIs('storeApi')) {
            $validation = Validator::make($request->all(), [
                'nom' => ['string', 'max:255', 'nullable'],
                'prenom' => ['string', 'max:255', 'nullable'],
                'email' => ['string', 'email', 'max:255', 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/', 'unique:'.User::class, 'nullable'],
                'numero_telephone' => ['int', 'regex:/^[0-9]{3}[0-9]{3}[0-9]{4}$/', 'nullable'],
                'password' => [Rules\Password::defaults(), 'nullable'],
            ], [
                'nom.max' => __('Le nom dépasse la limite de caractère de 255 caractères.'),
                'nom.string' => __('Le format du nom est invalide.'),
                'prenom.max' => __('Le prénom dépasse la limite de caractère de 255 caractères.'),
                'prenom.string' => __('Le format du prénom est invalide.'),
                'email.string' => __('Le format du courriel est invalide.'),
                'email.email' => __('Le format du courriel est invalide.'),
                'email.max' => __('Le courriel dépasse la limite de caractère de 255 caractères.'),
                'email.regex' => __('Le format du courriel est invalide.'),
                'email.unique' => __('Le courriel doit être unique.'),
                'numero_telephone.int' => __('Le format du numéro de téléphone est invalide.'),
                'numero_telephone.regex' => __('Le format du numéro de téléphone est invalide.'),
            ]);

            if ($validation->fails())
                return response()->json(['ERREUR' => $validation->errors()], 400);

            $user = User::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'numero_telephone' => $request->numero_telephone,
                'date_naissance' => $request->date_naissance,
                'password' => Hash::make($request->password),
                'est_actif' => 1,
                'id_ville' => null,
                'id_role' => 3
            ]);

            return response()->json(['data' => $user], 200);
        }
        else if ($request->routeIs('registerAdministrateurPost')) {
            $request->validate([
                'nom' => ['required', 'string', 'max:255'],
                'prenom' => ['required', 'string', 'max:255'],
                'date_naissance' => ['required', 'date'],
                'email' => ['required', 'string', 'email', 'max:255', 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/', 'unique:'.User::class],
                'numero_telephone' => ['required', 'int', 'regex:/^[0-9]{3}[0-9]{3}[0-9]{4}$/'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ], [
                'nom.required' => __('Le nom est requis.'),
                'nom.max' => __('Le nom dépasse la limite de caractère de 255 caractères.'),
                'nom.string' => __('Le format du nom est invalide.'),
                'prenom.required' => __('Le prénom est requis.'),
                'prenom.max' => __('Le prénom dépasse la limite de caractère de 255 caractères.'),
                'prenom.string' => __('Le format du prénom est invalide.'),
                'date_naissance.required' => __('La date de naissance est requise.'),
                'date_naissance.date' => __('Le format de la date de naissance est invalide.'),
                'email.required' => __('Le courriel est requis.'),
                'email.string' => __('Le format du courriel est invalide.'),
                'email.email' => __('Le format du courriel est invalide.'),
                'email.max' => __('Le courriel dépasse la limite de caractère de 255 caractères.'),
                'email.regex' => __('Le format du courriel est invalide.'),
                'email.unique' => __('Le courriel doit être unique.'),
                'numero_telephone.required' => __('Le numéro de téléphone est requis.'),
                'numero_telephone.int' => __('Le format du numéro de téléphone est invalide.'),
                'numero_telephone.regex' => __('Le format du numéro de téléphone est invalide.'),
                'password.required' => __('Le mot de passe est requis.'),
                'password.confirmed' => __('Le mot de passe doit être identique à la confirmation.')
            ]);

            $user = User::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'numero_telephone' => $request->numero_telephone,
                'date_naissance' => $request->date_naissance,
                'password' => Hash::make($request->password),
                'est_actif' => 1,
                'id_ville' => null,
                'id_role' => 1
            ]);

            return redirect()->to('register/administrateur/'. $user->id);
        }
        else {
            $roleId = 0;
            if ($request->routeIs('registerOrganisateur'))
                $roleId = 2;
            else
                $roleId = 3;

            $request->validate([
                'nom' => ['required', 'string', 'max:255'],
                'prenom' => ['required', 'string', 'max:255'],
                'date_naissance' => ['required', 'date'],
                'email' => ['required', 'string', 'email', 'max:255', 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/', 'unique:'.User::class],
                'numero_telephone' => ['required', 'int', 'regex:/^[0-9]{3}[0-9]{3}[0-9]{4}$/'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'ville' => ['required']
            ], [
                'nom.required' => __('Le nom est requis.'),
                'nom.max' => __('Le nom dépasse la limite de caractère de 255 caractères.'),
                'nom.string' => __('Le format du nom est invalide.'),
                'prenom.required' => __('Le prénom est requis.'),
                'prenom.max' => __('Le prénom dépasse la limite de caractère de 255 caractères.'),
                'prenom.string' => __('Le format du prénom est invalide.'),
                'date_naissance.required' => __('La date de naissance est requise.'),
                'date_naissance.date' => __('Le format de la date de naissance est invalide.'),
                'email.required' => __('Le courriel est requis.'),
                'email.string' => __('Le format du courriel est invalide.'),
                'email.email' => __('Le format du courriel est invalide.'),
                'email.max' => __('Le courriel dépasse la limite de caractère de 255 caractères.'),
                'email.regex' => __('Le format du courriel est invalide.'),
                'email.unique' => __('Le courriel doit être unique.'),
                'numero_telephone.required' => __('Le numéro de téléphone est requis.'),
                'numero_telephone.int' => __('Le format du numéro de téléphone est invalide.'),
                'numero_telephone.regex' => __('Le format du numéro de téléphone est invalide.'),
                'password.required' => __('Le mot de passe est requis.'),
                'password.confirmed' => __('Le mot de passe doit être identique à la confirmation.'),
                'ville.required' => __('La ville est requise.')
            ]);

            $user = User::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'numero_telephone' => $request->numero_telephone,
                'date_naissance' => $request->date_naissance,
                'password' => Hash::make($request->password),
                'est_actif' => 1,
                'id_ville' => $request->ville,
                'id_role' => $roleId
            ]);

            event(new Registered($user));

            Auth::login($user);

            return redirect(RouteServiceProvider::HOME);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if ($request->routeIs('suspendre')) {
            $id = $request->utilisateur;

            $user = User::find($id);

            if ($user->est_actif == 1) {
                $user->est_actif = 0;

                if ($user->save())
                    return response()->json(['SUCCES' => "L'utilisteur a bien ete suspendu."], 200);
                else
                    return response()->json(['ERREUR' => "L'utilisteur n'a pas ete suspendu."], 500);
            }
            else if ($user->est_actif == 0) {
                $user->est_actif = 1;

                if ($user->save())
                    return response()->json(['SUCCES' => "L'utilisteur a bien ete reactive."], 200);
                else
                    return response()->json(['ERREUR' => "L'utilisteur n'a pas ete reactive."], 500);
            }
        }
        if ($request->routeIs('supprimer')) {
            $id = $request->utilisateur;

            if (User::destroy($id))
                return response()->json(['SUCCES' => "L'utilisteur a bien ete supprimer."], 200);
            else
                return response()->json(['ERREUR' => "L'utilisteur n'a pas ete supprimer."], 500);
        }
    }
}
