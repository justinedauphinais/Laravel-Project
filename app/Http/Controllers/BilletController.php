<?php

/*****************************************************************************
Fichier : BilletController.php
Auteur : Louis-Philippe Racette
Fonctionnalité : S'occupe de la gestion gestion des billets
Date : 2023-04-30
 *****************************************************************************/

namespace App\Http\Controllers;

use App\Models\Billet;
use App\Models\Transaction;
use App\Models\Transaction_Representation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BilletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id_utilisateur' => 'required|numeric|gt:0'
        ], [
            'id_utilisateur.required' => __('L\'id de l\'utilisateur est requis'),
            'id_utilisateur.numeric' => __('L\'id de l\'utilisateur doit être un nombre entier'),
            'id_utilisateur.gt' => __('L\'id de l\'utilisateur doit être plus grand que 0')
        ]);

        if ($validation->fails()) {
            return response()->json([__('ERREUR') => $validation->errors()], 400);
        }

        $contenuDecode = $validation->validated();

        $utilisateur = User::find($contenuDecode['id_utilisateur']);

        if (empty($utilisateur)) {
            return response()->json([__('ERREUR') => __('L\'utilisateur n\'existe pas.')], 400);
        }

        $transactions = Transaction::where('id_utilisateur', $utilisateur->id)->get();

        if (sizeof($transactions) == 0) {
            return response()->json([__('ERREUR') => __('L\'utilisateur n\'a pas. pas de billet')], 400);
        }

        $id_tbl_jonction = array();
        // id table jonction besoins array
        for ($i = 0; $i < sizeof($transactions); $i++) {
            $resultats = Transaction_Representation::where('id_transaction', $transactions[$i]['id'])->get();

            for ($j = 0; $j < sizeof($resultats); $j++) {
                $id_tbl_jonction[] = $resultats[$j]['id'];
            }
        }

        return response()->json([__('SUCCÈS') => Billet::whereIn('id_transaction_representation', $id_tbl_jonction)->get()], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Billet $billet)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Billet $billet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Billet $billet)
    {
        $validation = Validator::make($request->all(), [
            'id_billet' => 'required|numeric|gt:0'
        ], [
            'id_billet.required' => __('L\'id du billet est requis'),
            'id_billet.numeric' => __('L\'id du billet doit être un nombre entier'),
            'id_billet.gt' => __('L\'id du billet doit être plus grand que 0')
        ]);

        if ($validation->fails()) {
            return response()->json([__('ERREUR') => $validation->errors()], 400);
        }

        $contenuDecode = $validation->validated();

        $billet = Billet::find($contenuDecode['id_billet']);

        if ($billet == null) {
            return response()->json([__('ERREUR') => __('Le billet n\'existe pas')], 400);
        }

        if ($billet->est_utilise == true) {
            return response()->json([__('ERREUR') => __('Le billet est déjà utilisé')], 400);
        }

        $billet->est_utilise = true;
        if ($billet->save()) {
            return response()->json([__('SUCCÈS') => __('Le billet a été utilisé')], 200);
        } else {
            return response()->json([__('ERREUR') => __('Le billet n\'a pas été updaté')], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Billet $billet)
    {
        //
    }
}
