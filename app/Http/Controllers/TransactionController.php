<?php

/*****************************************************************************
Fichier : TransactionController.php
Auteur : Louis-Philippe Racette
Fonctionnalité : S'occupe de la gestion gestion des transactions
Date : 2023-04-29
 *****************************************************************************/

namespace App\Http\Controllers;

use App\Models\Billet;
use App\Models\Representation;
use App\Models\Transaction;
use App\Models\Transaction_Representation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validation = Validator::make($request->all(), [
            'date_demande' => 'required|date',
            'token' => 'required|min:1',
            'id_utilisateur' => 'required|numeric|gt:0',
            'nbr_billets' => 'required|array|max:3',
            'nbr_billets.*' => 'required|numeric|gt:0',
            'id_representations' => 'required|array|max:3',
            'id_representations.*' => 'required|numeric|gt:0'
        ], [
            'date_demande.required' => __('La date de début de la transaction est requis'),
            'date_demande.date' => __('La date de début doit être une date'),
            'token.required' => __('Le token est requis'),
            'token.min' => __('La longueur du token doit être plus longue que 1'),
            'id_utilisateur.required' => __('L\'id de l\'utilisateur est requis'),
            'id_utilisateur.numeric' => __('L\'id de l\'utilisateur doit être un nombre entire'),
            'id_utilisateur.gt' => __('L\'id de l\'utilisateur doit être plus grand que 0'),
            'nbr_billets.required' => __('L\'array du nombre de billet est requis'),
            'nbr_billets.array' => __('L\'array du billet doit être un array'),
            'nbr_billets.max' => __('L\'array du nombre de billet doit être plus grand que 3'),
            'nbr_billets.*.required' => __('Le nombre de billet est requis'),
            'nbr_billets.*.numeric' => __('Le nombre de billet doit être un entier'),
            'nbr_billets.*.gt' => __('Le nombre de billet doit être plus grand que 0'),
            'id_representations.required' => __('L\'array de représentation est requis'),
            'id_representations.array' => __('L\'array de représentation doit être un array'),
            'id_representations.max' => __('L\'array de représentation ne doit pas dépasser 3 représentations'),
            'id_representations.*.required' => __('L\'id de représentation est requis'),
            'id_representations.*.numeric' => __('L\'id de représentation doit être un entier'),
            'id_representations.*.gt' => __('L\'id de représentation doit être plus grand que 0')
        ]);

        if ($validation->fails()) {
            return response()->json([__('ERREUR') => $validation->errors()], 400);
        }

        $contenuDecode = $validation->validated();
        try {

            // valide le nombre de place qu'il reste
            $nbr_places = array();

            $nbr_places = Representation::select('nbr_places')->whereIn('id', $contenuDecode['id_representations'])->get();

            // vérifie que l'événement existe
            if (empty($nbr_places)) {
                return response()->json([__('ERREUR') => __('il n\'y a pas de représentation avec ces id')], 400);
            }
            // $wordCount = Wordlist::where('id', '<=', $correctedComparisons)->count();
            for ($i = 0; $i < sizeof($contenuDecode['id_representations']); $i++) {
                $tbl_jonctions = Transaction_Representation::select('id')->where('id_representation', $contenuDecode['id_representations'][$i])->get();
                $nbr_billet_vendu = 0;

                // il est possible qu'il n'y aille pas encore de transaction pour cet événement
                if (!empty($tbl_jonctions)) {
                    $nbr_billet_vendu = Billet::whereIn('id_transaction_representation', $tbl_jonctions)->count();
                }

                // valide si le nombre de billet est en dessous de la limite
                if (($nbr_billet_vendu + $contenuDecode['nbr_billets'][$i]) > $nbr_places[$i]['nbr_places']) {
                    return response()->json([__('ERREUR') => __('Le nombre de billet dépasse la limite.')], 400);
                }
            }

            try {
                $transaction = Transaction::create([
                    'date_demande' => $contenuDecode['date_demande'],
                    'date_complete' => null,
                    'paye' => 0,
                    'token' => $contenuDecode['token'],
                    'id_utilisateur' => $contenuDecode['id_utilisateur']
                ]);
            } catch (QueryException $erreur) {
                return response()->json([__('ERREUR') => __('L\'id de l\'utilisateur n\'est pas valide.')], 400);
            }

            $id_tbl_jonctions = array();
            try {
                for ($i = 0; $i < sizeof($contenuDecode['id_representations']); $i++) {
                    $id_tbl_jonction = Transaction_Representation::create([
                        'id_transaction' => $transaction['id'],
                        'id_representation' => $contenuDecode['id_representations'][$i]
                    ]);

                    $id_tbl_jonctions[] = $id_tbl_jonction['id'];
                }
            } catch (QueryException $erreur) {
                return response()->json([__('ERREUR') => __('L\'id de l\'utilisateur n\'est pas valide échec.')], 400);
            }
            try {
                for ($i = 0; $i < sizeof($id_tbl_jonctions); $i++) {
                    for ($j = 0; $j < $contenuDecode['nbr_billets'][$i]; $j++) {
                        Billet::create([
                            'est_utilise' => false,
                            'est_actif' => false,
                            'id_transaction_representation' => $id_tbl_jonctions[$i]
                        ]);
                    }
                }
            } catch (QueryException $erreur) {
                return response()->json([__('ERREUR') => __('Les billets n\'ont pas été inséré.')], 400);
            }

            return response()->json([__('SUCCES') => __('La transaction a été ajoutée.')], 200);
        } catch (QueryException $erreur) {
            report($erreur);
            return response()->json([__('ERREUR') => __('La transaction n\'a pas été ajoutée.')], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validation = Validator::make($request->all(), [
            'date_complete' => 'required|date',
            'token' => 'required|min:1',
            'est_paye' => 'required|numeric|gt:0|lt:2'
        ], [
            'date_complete.required' => __('La date de fin de la transaction est requis'),
            'date_complete.date' => __('La date de de la transaction fin doit être une date'),
            'token.required' => __('Le token est requis'),
            'token.min' => __('La longueur du token doit être plus longue que 1'),
            'est_paye.required' => __('Le champ est payé est requis'),
            'est_paye.numeric' => __('Le champ est payé doit être un nombre'),
            'est_paye.gt' => __('Le champ est payé doit être plus grand que 0'),
            'est_paye.lt' => __('Le champ est payé doit être plus petit que 2'),
        ]);

        if ($validation->fails()) {
            return response()->json([__('ERREUR') => $validation->errors()], 400);
        }

        $contenuDecode = $validation->validated();

        // trouve la transaction
        $transaction = Transaction::firstWhere('token', $contenuDecode['token']);
        //return response()->json(['ERREUR' => $transaction], 400);
        if (empty($transaction)) {
            return response()->json([__('ERREUR') => __('La transaction n\'existe pas')], 400);
        }

        $transaction->paye = $contenuDecode['est_paye'];
        $transaction->date_complete = $contenuDecode['date_complete'];

        // valide que la transaction est updaté
        if (!$transaction->save()) {
            return response()->json([__('ERREUR') => __('La transaction n\' pas été updaté')], 400);
        }

        $id_tbl_jonction = array();

        $tbl_jonction = Transaction_Representation::where('id_transaction', $transaction->id)->get();

        for ($i = 0; $i < sizeof($tbl_jonction); $i++) {
            $id_tbl_jonction[] = $tbl_jonction[$i]['id'];
        }

        try {
            Billet::whereIn('id_transaction_representation', $id_tbl_jonction)->update(['est_actif' => $contenuDecode['est_paye']]);
        } catch (QueryException $erreur) {
            return response()->json([__('ERREUR') => __('Les billets n\'ont pas été update')], 400);
        }

        return response()->json([__('SUCCÈS') => __('La transaction et les billets ont été updaté')], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
