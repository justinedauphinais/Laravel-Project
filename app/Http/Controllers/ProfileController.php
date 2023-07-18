<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Ville;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'villes' => Ville::All()
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'nom' => ['string', 'max:255', 'nullable'],
            'prenom' => ['string', 'max:255', 'nullable'],
            'date_naissance' => ['date', 'nullable'],
            'email' => ['string', 'email', 'max:255', 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/', 'unique:'.User::class, 'nullable'],
            'numero_telephone' => ['int', 'regex:/^[0-9]{3}[0-9]{3}[0-9]{4}$/', 'nullable'],
            'password' => [Rules\Password::defaults(), 'nullable'],
        ], [
            'nom.max' => __('Le nom dépasse la limite de caractère de 255 caractères.'),
            'nom.string' => __('Le format du nom est invalide.'),
            'prenom.max' => __('Le prénom dépasse la limite de caractère de 255 caractères.'),
            'prenom.string' => __('Le format du prénom est invalide.'),
            'date_naissance.date' => __('Le format de la date de naissance est invalide.'),
            'email.string' => __('Le format du courriel est invalide.'),
            'email.email' => __('Le format du courriel est invalide.'),
            'email.max' => __('Le courriel dépasse la limite de caractère de 255 caractères.'),
            'email.regex' => __('Le format du courriel est invalide.'),
            'email.unique' => __('Le courriel doit être unique.'),
            'numero_telephone.int' => __('Le format du numéro de téléphone est invalide.'),
            'numero_telephone.regex' => __('Le format du numéro de téléphone est invalide.')
        ]);

        if ($validation->fails())
            return back()->withErrors($validation->errors())->withInput();
        else {
            $user = User::find($request->user()->id);
            $changesFound = FALSE;

            if ($request->nom != null) {
                $user->nom = $request->nom;
                $changesFound = TRUE;
            }
            if ($request->prenom != null) {
                $user->prenom = $request->prenom;
                $changesFound = TRUE;
            }
            if ($request->email != null) {
                $user->email = $request->email;
                $changesFound = TRUE;
            }
            if ($request->numero_telephone != null) {
                $user->numero_telephone = $request->numero_telephone;
                $changesFound = TRUE;
            }
            if ($request->password != null) {
                $user->password = Hash::make($request->password);
                $changesFound = TRUE;
            }
            if ($request->ville != null) {
                $user->id_ville = $request->ville;
                $changesFound = TRUE;
            }

            if ($changesFound == FALSE) {
                return view('profile.edit', [
                    'user' => $user,
                    'villes' => Ville::All()
                ]);
            }
            else if ($user->save()) {
                return view('profile.edit', [
                    'user' => $user,
                    'modifier' => TRUE,
                    'villes' => Ville::All()
                ]);
            }
            else {
                return view('profile.edit', [
                    'user' => $request->user(),
                    'modifier' => FALSE,
                    'villes' => Ville::All()
                ]);
            }
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's profile information.
     */
    public function updateAPI(Request $request, int $id)
    {
        $validation = Validator::make($request->all(), [
            'nom' => ['string', 'max:255', 'nullable'],
            'prenom' => ['string', 'max:255', 'nullable'],
            'date_naissance' => ['date', 'nullable'],
            'email' => ['string', 'email', 'max:255', 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/', 'unique:'.User::class, 'nullable'],
            'numero_telephone' => ['int', 'regex:/^[0-9]{3}[0-9]{3}[0-9]{4}$/', 'nullable'],
            'password' => [Rules\Password::defaults(), 'nullable'],
        ], [
            'nom.max' => __('Le nom dépasse la limite de caractère de 255 caractères.'),
            'nom.string' => __('Le format du nom est invalide.'),
            'prenom.max' => __('Le prénom dépasse la limite de caractère de 255 caractères.'),
            'prenom.string' => __('Le format du prénom est invalide.'),
            'date_naissance.date' => __('Le format de la date de naissance est invalide.'),
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
        else {
            $user = User::find($id);

            if ($request->nom != "")
                $user->nom = $request->nom;
            if ($request->prenom != "")
                $user->prenom = $request->prenom;
            if ($request->email != "")
                $user->email = $request->email;
            if ($request->numero_telephone != null)
                $user->numero_telephone = $request->numero_telephone;
            if ($request->password != "")
                $user->password = $request->password;
            if ($request->id_ville != 0)
                $user->id_ville = $request->id_ville;
            if ($request->date_naissance != "")
                $user->date_naissance = $request->date_naissance;

            if ($user->save()) {
                return response()->json(['data' => $user], 200);
            }
            else
                return response()->json(['ERREUR' => __("L'utilisateur n'a pas ete modifie.")], 400);

        }

        return response()->json(['SUCCES' => __("Aucun changement")], 200);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
