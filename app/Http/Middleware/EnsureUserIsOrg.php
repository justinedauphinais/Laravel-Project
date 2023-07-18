<?php namespace App\Http\Middleware;
/*****************************************************************************
 Fichier : EnsureUserIsOrg.php
 Auteur : Justine Dauphinais
 Fonctionnalité : Permet la vérification que l'utilisateur est un organisateur
 Date : 4 mai 2023
*****************************************************************************/

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsOrg
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
            if ($utilisateur->id_role == 2 and $utilisateur->est_actif == 1) {
                return $next($request);
            }

            if ($request->bearerToken() && $request->accepts('application/json'))
                return response()->json(['ERREUR' => 'Veuillez vous authentifier avec un compte organisateur'], 400);

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect("/login")->with('error', __('Vous devez être authentifié avec un compte organisateur pour utiliser cette fonctionnalité.'));
    }
}
