<?php namespace App\Http\Middleware;
/*****************************************************************************
 Fichier : EnsureUserIsUser.php
 Auteur : Justine Dauphinais
 Fonctionnalité : Permet la vérification que l'utilisateur est un administrateur
 Date : 28 avril 2023
*****************************************************************************/

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $utilisateur = $request->user();

        if ($utilisateur !== null) {
            if ($utilisateur->id_role == 1 and $utilisateur->est_actif == 1) {
                return $next($request);
            }

            if ($request->bearerToken() && $request->accepts('application/json')) {
                return response()->json(['ERREUR' => 'Veuillez vous authentifier avec un compte administrateur'], 400);
            }

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect("/login");
        }

        return redirect("/login")->with('error', __('Vous devez être authentifié avec un compte administrateur pour utiliser cette fonctionnalité.'));
    }
}
