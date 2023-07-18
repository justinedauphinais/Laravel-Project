<?php namespace App\Http\Middleware;
/*****************************************************************************
 Fichier : EnsureUserIsUser.php
 Auteur : Justine Dauphinais
 Fonctionnalité : Permet la vérification que l'utilisateur est un utilisateur
 Date : 4 mai 2023
*****************************************************************************/

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsUser
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
            if ($utilisateur->id_role == 3) {
                return $next($request);
            }

            if ($request->bearerToken() && $request->accepts('application/json')) {
                return response()->json(['ERREUR' => 'Veuillez vous authentifier avec un compte utilisateur'], 400);
            }

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        if ($request->bearerToken() && $request->accepts('application/json')) {
            return response()->json(['ERREUR' => 'Veuillez vous authentifier avec un compte utilisateur'], 400);
        }

        return redirect()->back()->with(__('alerte'), __('Vous devez être authentifié avec un compte utilisateur pour utiliser cette fonctionnalité.'));

    }
}
