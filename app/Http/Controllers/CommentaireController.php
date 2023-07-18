<?php

/*****************************************************************************
Fichier : CommentaireController.php
Auteur : Louis-Philippe Racette
Fonctionnalité : S'occupe de la gestion gestion des commentaires
Date : 2023-05-02
 *****************************************************************************/

namespace App\Http\Controllers;

use App\Models\Commentaire;
use App\Models\Evenement;
use App\Models\Representation;
use App\Models\Transaction;
use App\Models\Transaction_Representation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\View\View;
use stdClass;

class CommentaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // pour la collections de commentaire
        $commentaires = array(); // un
        $evenement = null;
        $arr_user_jonction = array();

        if ($request->routeIs('commentaires')) {
            $validation = Validator::make($request->all(), [
                'id_evenement' => 'required|numeric|gt:0',
            ], [
                'id_evenement.required' => __('L\'id de l\'evenement est requis'),
                'id_evenement.numeric' => __('L\'id de l\'evenement doit être un nombre entier'),
                'id_evenement.gt' => __('L\'id de l\'evenement doit être plus grand que 0')
            ]);

            if ($validation->fails()) {
                return response()->json([__('ERREUR') => $validation->errors()], 400);
            }

            $contenuDecode = $validation->validated();

            $evenement = Evenement::find($contenuDecode['id_evenement']);

            if ($evenement == null) {
                return response()->json([__('ERREUR') => __('Il n\'existe pas')], 400);
            }

            $representations = Representation::where('id_evenement', $evenement->id)->get();

            $representations_id = array();

            for ($i = 0; $i < sizeof($representations); $i++) {
                $representations_id[] = $representations[$i]['id'];
            }


            $tbl_jonctions = Transaction_Representation::whereIn('id_representation', $representations_id)->get();
            $tbl_jonctions_id = array();
            $jonction_transactions_id = array();

            for ($i = 0; $i < sizeof($tbl_jonctions); $i++) {
                $jonction_transactions_id[] = $tbl_jonctions[$i]['id_transaction'];
                $tbl_jonctions_id[] = $tbl_jonctions[$i]['id'];
            }

            $transactions = Transaction::whereIn('id', $jonction_transactions_id)->get();

            $transactions_id = array();
            $users_id = array();

            for ($i = 0; $i < sizeof($transactions); $i++) {
                $transactions_id[] = $transactions[$i]['id'];
                $users_id[] = $transactions[$i]['id_utilisateur'];
            }

            $users = User::whereIn('id', $users_id)->get();

            // les commentaires
            $commentaires = Commentaire::whereIn('id_transaction_representation', $tbl_jonctions_id)->get();

            // les users   $arr_user_jonction
            for ($i = 0; $i < sizeof($tbl_jonctions); $i++) {   // les représentations
                for ($j = 0; $j < sizeof($transactions); $j++) {    // les transactions
                    if ($transactions[$j]['id'] == $tbl_jonctions[$i]['id_transaction']) {
                        for ($k = 0; $k < sizeof($users); $k++) {   // les users
                            if ($transactions[$j]['id_utilisateur'] == $users[$k]['id']) {
                                $arr_user_jonction[$tbl_jonctions[$i]['id']] = $users[$k];
                                break;
                            }
                        }
                        break;
                    }
                }
            }

            return response()->json([$commentaires, $arr_user_jonction, $tbl_jonctions], 200);
        }

        // si on veut afficher une première fois
        if ($request->routeIs('afficherCommentaire') or $request->routeIs('afficherCommentaireAdmin')) {
            $validation = Validator::make($request->all(), [
                'id_evenement' => 'required|numeric|gt:0',
            ], [
                'id_evenement.required' => __('L\'id de l\'evenement est requis'),
                'id_evenement.numeric' => __('L\'id de l\'evenement doit être un nombre entier'),
                'id_evenement.gt' => __('L\'id de l\'evenement doit être plus grand que 0')
            ]);

            if ($validation->fails()) {
                return back()->withErrors($validation->errors())->withInput();
            }

            $contenuDecode = $validation->validated();

            $evenement = Evenement::find($contenuDecode['id_evenement']);

            if ($evenement == null) {
                return back()->withErrors(__('Pas d\'evenement avec cet id'))->withInput();
            }

            $representations = Representation::where('id_evenement', $evenement->id)->get();

            $representations_id = array();

            for ($i = 0; $i < sizeof($representations); $i++) {
                $representations_id[] = $representations[$i]['id'];
            }


            $tbl_jonctions = Transaction_Representation::whereIn('id_representation', $representations_id)->get();
            $tbl_jonctions_id = array();
            $jonction_transactions_id = array();

            for ($i = 0; $i < sizeof($tbl_jonctions); $i++) {
                $jonction_transactions_id[] = $tbl_jonctions[$i]['id_transaction'];
                $tbl_jonctions_id[] = $tbl_jonctions[$i]['id'];
            }

            $transactions = Transaction::whereIn('id', $jonction_transactions_id)->get();

            $transactions_id = array();
            $users_id = array();

            for ($i = 0; $i < sizeof($transactions); $i++) {
                $transactions_id[] = $transactions[$i]['id'];
                $users_id[] = $transactions[$i]['id_utilisateur'];
            }

            $users = User::whereIn('id', $users_id)->get();

            // les commentaires
            $commentaires = Commentaire::whereIn('id_transaction_representation', $tbl_jonctions_id)->get();

            // les users   $arr_user_jonction
            for ($i = 0; $i < sizeof($tbl_jonctions); $i++) {   // les représentations
                for ($j = 0; $j < sizeof($transactions); $j++) {    // les transactions
                    if ($transactions[$j]['id'] == $tbl_jonctions[$i]['id_transaction']) {
                        for ($k = 0; $k < sizeof($users); $k++) {   // les users
                            if ($transactions[$j]['id_utilisateur'] == $users[$k]['id']) {
                                $arr_user_jonction[$tbl_jonctions[$i]['id']] = $users[$k];
                                break;
                            }
                        }
                        break;
                    }
                }
            }
        }

        // si c'est le formulaire avec la recherche
        if ($request->routeIs('afficherCommentaireRecherche') or $request->routeIs('afficherCommentaireRechercheAdmin')) {
            $validation = Validator::make($request->all(), [
                'id_evenement' => 'required|numeric|gt:0',
                'contenu' => 'max:255'
            ], [
                'id_evenement.required' => __('L\'id de l\'evenement est requis'),
                'id_evenement.numeric' => __('L\'id de l\'evenement doit être un nombre entier'),
                'id_evenement.gt' => __('L\'id de l\'evenement doit être plus grand que 0'),
                'contenu' => __('Le contenu est trop long')
            ]);

            if ($validation->fails()) {

                $evenement = new stdClass();
                $evenement->nom = 'Erreur';
                $evenement->id = $request['id_evenement'];
                return view('commentaire/afficher-commentaire', [
                    'evenement' => $evenement,
                    'titre' => __('L\'événement n\'est pas trouvable'),
                    'errors' => $validation->errors()
                ]);
            }

            $contenuDecode = $validation->validated();

            $evenement = Evenement::find($contenuDecode['id_evenement']);

            $representations = Representation::where('id_evenement', $evenement->id)->get();

            $representations_id = array();

            for ($i = 0; $i < sizeof($representations); $i++) {
                $representations_id[] = $representations[$i]['id'];
            }


            $tbl_jonctions = Transaction_Representation::whereIn('id_representation', $representations_id)->get();
            $tbl_jonctions_id = array();
            $jonction_transactions_id = array();

            for ($i = 0; $i < sizeof($tbl_jonctions); $i++) {
                $jonction_transactions_id[] = $tbl_jonctions[$i]['id_transaction'];
                $tbl_jonctions_id[] = $tbl_jonctions[$i]['id'];
            }

            $transactions = Transaction::whereIn('id', $jonction_transactions_id)->get();

            $transactions_id = array();
            $users_id = array();

            for ($i = 0; $i < sizeof($transactions); $i++) {
                $transactions_id[] = $transactions[$i]['id'];
                $users_id[] = $transactions[$i]['id_utilisateur'];
            }

            $users = User::whereIn('id', $users_id)->get();

            // les commentaires
            $commentaires = Commentaire::whereIn('id_transaction_representation', $tbl_jonctions_id)->where('commentaire', 'like', '%' . $contenuDecode['contenu'] . '%')->get();

            // les users   $arr_user_jonction
            for ($i = 0; $i < sizeof($tbl_jonctions); $i++) {   // les représentations
                for ($j = 0; $j < sizeof($transactions); $j++) {    // les transactions
                    if ($transactions[$j]['id'] == $tbl_jonctions[$i]['id_transaction']) {
                        for ($k = 0; $k < sizeof($users); $k++) {   // les users
                            if ($transactions[$j]['id_utilisateur'] == $users[$k]['id']) {
                                $arr_user_jonction[$tbl_jonctions[$i]['id']] = $users[$k];
                                break;
                            }
                        }
                        break;
                    }
                }
            }
        }


        return view('commentaire/afficher-commentaire', [
            'evenement' => $evenement,
            'commentaires' => $commentaires,
            'users' => $arr_user_jonction
        ]);
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
            'id_utilisateur' => 'required|numeric|gt:0',
            'id_evenement' => 'required|numeric|gt:0',
            'message' => 'required|max:255'
        ], [
            'id_utilisateur.required' => __('L\'id de l\'utilisateur est requis'),
            'id_utilisateur.numeric' => __('L\'id de l\'utilisateur doit être un nombre entier'),
            'id_utilisateur.gt' => __('L\'id de l\'utilisateur doit être plus grand que 0'),
            'id_evenement.required' => __('L\'id de l\'evenement est requis'),
            'id_evenement.numeric' => __('L\'id de l\'evenement doit être un nombre entier'),
            'id_evenement.gt' => __('L\'id de l\'evenement doit être plus grand que 0'),
            'message.required' => __('Le message est requis'),
            'message.max' => __('Le message doit être de 255 caractères au maximum')
        ]);

        if ($validation->fails()) {
            return response()->json([__('ERREUR') => $validation->errors()], 400);
        }

        $contenuDecode = $validation->validated();

        $transactions = Transaction::where('id_utilisateur', $contenuDecode['id_utilisateur'])->get();

        if (sizeof($transactions) == 0) {
            return response()->json([__('ERREUR') => __('L\'utilisateur n\'a pas d\'achat')], 400);
        }

        $representations = Representation::where('id_evenement', $contenuDecode['id_evenement'])->get();

        if (sizeof($representations) == 0) {
            return response()->json([__('ERREUR') => __('L\'événement n\'existe pas')], 400);
        }

        // les array d'id possible (plus facile pour rechercher)
        $transactions_id = array();
        $representations_id = array();

        for ($i = 0; $i < sizeof($transactions); $i++) {
            $transactions_id[] = $transactions[$i]['id'];
        }

        for ($i = 0; $i < sizeof($representations); $i++) {
            $representations_id[] = $representations[$i]['id'];
        }

        $tbl_jonction = Transaction_Representation::whereIn('id_transaction', $transactions_id)->whereIn('id_representation', $representations_id)->first();

        try {
            Commentaire::create([
                'commentaire' => $contenuDecode['message'],
                'est_actif' => true,
                'id_transaction_representation' => $tbl_jonction['id']
            ]);
            return response()->json([__('SUCCÈS') => __('Le commentaire a été inséré.')], 200);
        } catch (QueryException $th) {
            return response()->json([__('ERREUR') => __('Le commentaire n\'a pas été inséré.')], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Commentaire $commentaire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commentaire $commentaire)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Commentaire $commentaire)
    {
        //return response()->json([__('ERREUR') => $request->all()], 400);
        // masquer avec api
        if ($request->routeIs('activerCommentaire')) {
            $validation = Validator::make($request->all(), [
                'id_commentaire' => 'required|numeric|gt:0',
                'activer' => 'required|numeric|gt:-1|lt:2'
            ], [
                'id_commentaire.required' => __('L\'id du commentaire est requis'),
                'id_commentaire.numeric' => __('L\'id du commentaire doit être un nombre entier'),
                'id_commentaire.gt' => __('L\'id du commentaire doit être plus grand que 0'),
                'activer.required' => __('Le champ activer est requis'),
                'activer.numeric' => __('Le champ activer doit être un nombre'),
                'activer.gt' => __('Le champ activer doit être plus grand que -1'),
                'activer.lt' => __('Le champ activer doit être plus petit que 2')
            ]);

            if ($validation->fails()) {
                return response()->json([__('ERREUR') => $validation->errors()], 400);
            }

            $contenuDecode = $validation->validated();

            $commentaire = Commentaire::find($contenuDecode['id_commentaire']);

            if ($commentaire == null) {
                return response()->json([__('ERREUR') => __('Le commentaire n\'existe pas')], 400);
            }

            $commentaire->est_actif = $contenuDecode['activer'];
            if ($commentaire->save()) {
                return response()->json([__('SUCCÈS') => __('Le commentaire a été updaté')], 200);
            } else {
                return response()->json([__('ERREUR') => __('Le commentaire n\'a pas été updaté')], 400);
            }
        }


        $validation = Validator::make($request->all(), [
            'id_commentaire' => 'required|numeric|gt:0',
            'message' => 'required|max:255'
        ], [
            'id_commentaire.required' => __('L\'id du commentaire est requis'),
            'id_commentaire.numeric' => __('L\'id du commentaire doit être un nombre entier'),
            'id_commentaire.gt' => __('L\'id du commentaire doit être plus grand que 0'),
            'message.required' => __('Le message est requis'),
            'message.max' => __('Le message doit être de 255 caractères au maximum')
        ]);

        if ($validation->fails()) {
            return response()->json([__('ERREUR') => $validation->errors()], 400);
        }

        $contenuDecode = $validation->validated();

        $commentaire = Commentaire::find($contenuDecode['id_commentaire']);

        if ($commentaire == null) {
            return response()->json([__('ERREUR') => __('Le commentaire n\'existe pas')], 400);
        }

        $commentaire->commentaire = $contenuDecode['message'];

        if ($commentaire->save()) {
            return response()->json([__('SUCCÈS') => __('Le commentaire a été updaté')], 200);
        } else {
            return response()->json([__('ERREUR') => __('Le commentaire n\'a pas été updaté')], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id_commentaire' => 'required|numeric|gt:0'
        ], [
            'id_commentaire.required' => __('L\'id du commentaire est requis'),
            'id_commentaire.numeric' => __('L\'id du commentaire doit être un nombre entier'),
            'id_commentaire.gt' => __('L\'id du commentaire doit être plus grand que 0')
        ]);

        if ($validation->fails()) {
            return response()->json([__('ERREUR') => $validation->errors()], 400);
        }

        $contenuDecode = $validation->validated();

        if (Commentaire::destroy($contenuDecode['id_commentaire'])) {
            return response()->json([__('SUCCES') => __('Le commentaire a été supprimé')], 200);
        }
        return response()->json([__('ERREUR') => __('Le commentaire n\'a été supprimé')], 400);
    }
}
