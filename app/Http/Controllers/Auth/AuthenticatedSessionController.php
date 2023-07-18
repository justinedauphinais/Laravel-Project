<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Resources\UserResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $user = User::where('email', '=', $request->email)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['error' => __('Le courriel et le mot de passe n\'existe pas.')]);
        }
        else if ($user->est_actif == 1) {
            if (Hash::check($request->password, $user->password)) {
                $request->authenticate();

                $request->session()->regenerate();

                return redirect()->intended(RouteServiceProvider::HOME);
            }
            else {
                return redirect()->back()->withErrors(['error' => __('Le courriel et le mot de passe n\'existe pas.')]);
            }
        }
        else if ($user->est_actif == 0) {
            return redirect()->back()->withErrors(['error' => __('L\'utilisateur a été désactivé.')]);
        }
    }

    public function loginApi(Request $request) {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'mot_de_passe' => 'required'
        ], [
            'email.required' => __('Veuillez entrer le courriel de l\'utilisateur.'),
            'email.email' => __('Le courriel de l\'utilisateur doit être valide.'),
            'mot_de_passe.required' => __('Veuillez entrer le mot de passe de l\'utilisateur.')
        ]);

        if ($validation->fails())
            return response()->json(['error' => $validation->errors()], 400);

        $user = User::where('email', '=', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => __('Le courriel et le mot de passe n\'existe pas.')]);
        }
        else if ($user->est_actif == 1) {
            if (Hash::check($request->mot_de_passe, $user->password)) {
                return new UserResource($user);
            }
            else {
                return response()->json(['error' => __('Le courriel et le mot de passe n\'existe pas.')]);
            }
        }
        else if ($user->est_actif == 0) {
            return response()->json(['error' => __('L\'utilisateur a été désactivé.')]);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
