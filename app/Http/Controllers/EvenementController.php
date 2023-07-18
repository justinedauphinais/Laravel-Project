<?php

/*****************************************************************************
Fichier : EvenementController.php
Auteur : Louis-Philippe Racette, Matias Beaulieu
Fonctionnalité : S'occupe de la gestion des événements
Date : 2023-04-25
 *****************************************************************************/

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Evenement;
use App\Models\Pays;
use App\Models\Representation;
use App\Models\Statut;
use App\Models\Ville;
#use App\Models\Transaction;
use App\Models\Transaction_Representation;
use App\Models\Billet;
use Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use App\Http\Resources\EvenementRessource;

//pour la date

class EvenementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $base_inputs = [];

        $base_message = [];

        $array_db_request = array();

        $array_inputs = $request->all();

        // pour la recherche avec une date indique si le champ date est dans les inputs
        $date_flag = null;

        if (isset($array_inputs['titre']) && $array_inputs['titre'] != "") {
            $base_inputs['titre'] = 'regex:/[A-Za-z0-9 _]?[A-Za-z0-9 _\',?!\.]*$/';
            $base_message['titre.regex'] = __('Le champ titre doit être un format valide');

            $array_db_request[] = ['nom', 'like', "%" . $array_inputs['titre'] . "%"];
        }

        if (isset($array_inputs['date']) && $array_inputs['date'] != "") {
            $base_inputs['date'] = 'date_format:Y-m-d';
            $base_message['date.date_format'] = __('Le champ date doit être un format valide');

            $date_flag = True;
        }

        if (isset($array_inputs['categorie']) && $array_inputs['categorie'] != 0) {
            $base_inputs['categorie'] = 'regex:/^[1-9][0-9]*/';
            $base_message['categorie.regex'] = __('Le categorie date doit être un format valide');

            $array_db_request[] = ['id_categorie', '=', $array_inputs['categorie']];
        }

        // si c'est la page organisateur
        if ($request->routeIs('afficherEvenementsOrganisateur')) {
            $array_db_request[] = ['id_utilisateur', '=', Auth::id()];
        }

        $validation = Validator::make($request->all(), $base_inputs, $base_message);

        if ($validation->fails())
            return back()->withErrors($validation->errors())->withInput($request->input());

        // pour la date tri avec le input date vu que c'est différent
        //TODO trouver un meilleur moyen de le faire
        if ($date_flag != null) {

            $representations = DB::table('representations')->select('id_evenement')->distinct()->where('date', '=', $array_inputs['date'])->get();
            $array = [];
            for ($i = 0; $i < sizeof($representations); $i++) {
                $array[] = $representations[$i]->id_evenement;
            }

            $evenements = Evenement::whereIn('id', $array)->where($array_db_request)->get();
        } else {

            $evenements = DB::table('evenements')->where($array_db_request)->get();
        }

        // verifie si on a des resultat du tri
        if (sizeof($evenements) == 0) {
            $evenements = null;
        }

        if (sizeof($array_db_request) > 0 || $date_flag != null) {
            return view('evenement/evenements', [
                'categories' => Categorie::all(),
                'evenements' => $evenements,
            ]);
        } else {
            return view('evenement/evenements', [
                'categories' => Categorie::all(),
                'evenements' => Evenement::all(),
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /* TODO ajouter la validation et les autres étapes */
        return view('evenement/formulaire-evenement', [
            'statuts' => Statut::all(),
            'pays' => Pays::all(),
            'categories' => Categorie::where('est_actif', '=', true)->get(),
            'villes' => Ville::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Pour avoir le bon timezone
        $date = new \DateTime(null, new \DateTimeZone('America/New_York'));


        // TODO faire que le lien peut être null
        $base_inputs = [
            'titre' => 'required|regex:/^[A-Za-z0-9 _]?[A-Za-z0-9 _\',?!\.]*$/',
            'etat' => 'required|regex:/^[1-9][0-9]*$/',
            'code_postal' => 'required|regex:/^[A-Z]\d[A-Z][ -]?\d[A-Z]\d$/',
            'adresse' => 'required|regex:/[- ,\/0-9a-zA-Z]+/',
            'lien' => 'required|regex:/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&\/\/=]*)/',
            'ville' => 'required|regex:/^[1-9][0-9]*/',
            'pays' => 'required|regex:/^[1-9][0-9]*/',
            'categorie' => 'required|regex:/^[1-9][0-9]*/',
            'prix_billet' => 'required|regex:/^[0-9][0-9]*\.[0-9]?[0-9]$/',
            'date1' => 'required|after_or_equal:' . $date->format('Y-m-d H:i:s'),
            'nombre_billet1' => 'required|regex:/^[0-9][0-9]*$/',
            'representation_active1' => 'required',
        ];

        $base_message = [
            'titre.required' => __("Le champ titre est requis"),
            'titre.regex' => __('Le titre doit avoir un nom valide'),
            'etat.required' => __('Le champ État est requis'),
            'etat.regex' => __('L\'état doit être d\'un format valide'),
            'code_postal.required' => __('Le champ code postal est requis'),
            'code_postal.regex' => __('Le code postal doit être un format valide'),
            'adresse.required' => __('Le champ adresse est requis'),
            'adresse.regex' => __('L\'adresse doit être un format valide'),
            'lien.required' => __('Le champ Lien est requis'),
            'lien.regex' => __('Le lien doit être un format valide'),
            'ville.required' => __('Le champ ville est requis'),
            'ville.regex' => __('La ville doit être valide'),
            'pays.required' => __('Le champ pays est requis'),
            'pays.regex' => __('Le pays doit être valide'),
            'categorie.required' => __('Le champ catégorie est requis'),
            'categorie.regex' => __('La catégorie doit être un format valide'),
            'prix_billet.required' => __('Le champ prix billet est requis'),
            'prix_billet.regex' => __('Le prix du billet doit être un format valide'),
            'date1.required' => __('Le champ date 1 est requis'),
            'date1.after_or_equal' => __('La date 1 doit être aujourd\'hui ou plus tard'),
            'nombre_billet1.required' => __('Le champ nombre de billet 1 est requis'),
            'nombre_billet1.regex' => __('Le nombre de billet 1 doit être un format valide'),
            'representation_active1.required' => __('La case représentation active 1 est requise')
        ];

        $array_inputs = $request->all();

        // vérifie s'il y a d'autre représentation
        if ((isset($array_inputs['date2']) && $array_inputs['date2'] != "") || (isset($array_inputs['nombre_billet2']) && $array_inputs['nombre_billet2'] != "")) {
            $base_inputs['date2'] = "required|after_or_equal:" . $date->format('Y-m-d H:i:s');
            $base_inputs['nombre_billet2'] = "required|regex:/^[0-9][0-9]*$/";
            $base_inputs['representation_active2'] = "regex:/.*/";

            $base_message['date2.required'] = __('Le champ date 2 est requis');
            $base_message['date2.after_or_equal'] = __('La date2 doit être aujourd\'hui ou plus tard');
            $base_message['nombre_billet2.required'] = __('Le champ nombre de billet 2 est requis');
            $base_message['nombre_billet2.regex'] = __('Le nombre de billet 2 doit être un format valide');
            $base_message['representation_active2.regex'] = "La case représentation active 2 doit être valide";
        }

        if ((isset($array_inputs['date3']) && $array_inputs['date3'] != "") || (isset($array_inputs['nombre_billet3']) && $array_inputs['nombre_billet3'] != "")) {
            $base_inputs['date3'] = "required|after_or_equal:" . $date->format('Y-m-d H:i:s');
            $base_inputs['nombre_billet3'] = "required|regex:/^[0-9][0-9]*$/";
            $base_inputs['representation_active3'] = "regex:/.*/";

            $base_message['date3.required'] = __('Le champ date 3 est requis');
            $base_message['date3.after_or_equal'] = __('La date3 doit être aujourd\'hui ou plus tard');
            $base_message['nombre_billet3.required'] = __('Le champ nombre de billet 3 est requis');
            $base_message['nombre_billet3.regex'] = __('Le nombre de billet 3 doit être un format valide');
            $base_message['representation_active3.regex'] = "La case représentation active 3 doit être valide";
        }

        //TODO ajouter le user
        $validation = Validator::make($request->all(), $base_inputs, $base_message);

        if ($validation->fails())
            return back()->withErrors($validation->errors())->withInput($request->input());

        $contenuFormulaire = $validation->validated();

        // insertion dans la bd
        // TODO faire insertion avec table de jonction
        try {
            $evenement = Evenement::create([
                'nom' => $contenuFormulaire['titre'],
                'lieu' => $contenuFormulaire['adresse'],
                'lien' => $contenuFormulaire['lien'],
                'est_actif' => 1,
                'path_photo' => 'bidon', //TODO implémenter l'ajout d'une image
                'code_postal' => $contenuFormulaire['code_postal'],
                'id_utilisateur' => Auth::id(),
                'id_statut' => $contenuFormulaire['etat'],
                'id_ville' => $contenuFormulaire['ville'],
                'id_categorie' => $contenuFormulaire['categorie']
            ]);

            // TODO mieux implémenter
            $date = $contenuFormulaire['date1'];
            $date = strtotime($date);

            Representation::create([
                'date' => date('Y-m-d', $date),
                'heure' => date('H:i:s', $date),
                'nbr_places' => $contenuFormulaire['nombre_billet1'],
                'est_actif' => (isset($contenuFormulaire['representation_active1']) ? true : false),
                'prix' => $contenuFormulaire['prix_billet'],
                'id_evenement' => $evenement->id,
            ]);


            if ($array_inputs['date2'] != "") {
                $date = $contenuFormulaire['date2'];
                $date = strtotime($date);

                Representation::create([
                    'date' => date('Y-m-d', $date),
                    'heure' => date('H:i:s', $date),
                    'nbr_places' => $contenuFormulaire['nombre_billet2'],
                    'est_actif' => (isset($contenuFormulaire['representation_active2']) ? true : false),
                    'prix' => $contenuFormulaire['prix_billet'],
                    'id_evenement' => $evenement->id,
                ]);
            }

            if ($array_inputs['date3'] != "") {
                $date = $contenuFormulaire['date3'];
                $date = strtotime($date);

                Representation::create([
                    'date' => date('Y-m-d', $date),
                    'heure' => date('H:i:s', $date),
                    'nbr_places' => $contenuFormulaire['nombre_billet3'],
                    'est_actif' => (isset($contenuFormulaire['representation_active3']) ? true : false),
                    'prix' => $contenuFormulaire['prix_billet'],
                    'id_evenement' => $evenement->id,
                ]);
            }
        } catch (QueryException $erreur) {
            echo ($erreur);
        }


        // envoie vers la page de confirmation
        return view('evenement/confirmation-creation-evenement', [
            'titre' => $contenuFormulaire['titre'],
            'etat' => $contenuFormulaire['etat'],
            'code_postal' => $contenuFormulaire['code_postal'],
            'adresse' => $contenuFormulaire['adresse'],
            'lien' => $contenuFormulaire['lien'],
            'ville' => $contenuFormulaire['ville'],
            'pays' => $contenuFormulaire['pays'],
            'categorie' => $contenuFormulaire['categorie'],
            'prix_billet' => $contenuFormulaire['prix_billet'],
            'date1' => $contenuFormulaire['date1'],
            'representation1' => $contenuFormulaire['nombre_billet1'],
            'actif1' => (isset($contenuFormulaire['representation_active1']) ? __("Oui") : __("Non")),
            'date2' => (isset($contenuFormulaire['date2']) ? $contenuFormulaire['date2'] : False),
            'representation2' => (isset($contenuFormulaire['nombre_billet2']) ? $contenuFormulaire['nombre_billet2'] : 0),
            'actif2' => (isset($contenuFormulaire['representation_active2']) ? __("Oui") : __("Non")),
            'date3' => (isset($contenuFormulaire['date3']) ? $contenuFormulaire['date3'] : False),
            'representation3' => (isset($contenuFormulaire['nombre_billet3']) ? $contenuFormulaire['nombre_billet3'] : 0),
            'actif3' => (isset($contenuFormulaire['representation_active3']) ? __("Oui") : __("Non")),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Evenement $evenement, Request $request, int $id = 0)
    {
        if ($request->routeIs('evenementsApi')) {

            $evenements = Evenement::where('est_actif', 1)->get();

            return response()->json($evenements, 200);
        }
        else if ($request->routeIs('evenementApi')) {

            $evenement = Evenement::find($id);

            if (empty($evenement))
                return response()->json(['ERREUR' => 'L\'événement demandé est introuvable.'], 400);

            return new EvenementRessource($evenement);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Evenement $evenement)
    {
        $evenement = Evenement::find($request->input('id_evenement'));

        if ($evenement == false) {
            return redirect()->action([EvenementController::class, 'index']);
        }

        $representations = Representation::where('id_evenement', '=', $evenement->id)
        ->get();

        $billets_vendus = array();

        for ($i = 0; $i < count($representations); $i++) {
            $tbl_jonctions = Transaction_Representation::select('id')->where('id_representation', $representations[$i]->id)->get();

            array_push($billets_vendus, Billet::whereIn('id_transaction_representation', $tbl_jonctions)->count());
        }

        return view('evenement/modif-consulter-evenement', [
            'billets_vendus' => $billets_vendus,
            'representations' => $representations,
            'evenement' => $evenement,
            'statuts' => Statut::all(),
            'pays' => Pays::all(),
            'categories' => Categorie::all(),
            'villes' => Ville::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Evenement $evenement)
    {
        // Pour avoir le bon timezone
        $date = new \DateTime(null, new \DateTimeZone('America/New_York'));


        // TODO faire que le lien peut être null
        $base_inputs = [
            'titre' => 'required|regex:/^[A-Za-z0-9 _]?[A-Za-z0-9 _\',?!\.]*$/',
            'etat' => 'required|regex:/^[1-9][0-9]*$/',
            'code_postal' => 'required|regex:/^[A-Z]\d[A-Z][ -]?\d[A-Z]\d$/',
            'adresse' => 'required|regex:/[- ,\/0-9a-zA-Z]+/',
            'lien' => 'required|regex:/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&\/\/=]*)/',
            'ville' => 'required|regex:/^[1-9][0-9]*/',
            'pays' => 'required|regex:/^[1-9][0-9]*/',
            'categorie' => 'required|regex:/^[1-9][0-9]*/',
            'prix_billet' => 'required|regex:/^[0-9][0-9]*\.[0-9]?[0-9]$/',
            'date1' => 'required|after_or_equal:' . $date->format('Y-m-d H:i:s'),
            'nombre_billet1' => 'required|regex:/^[0-9][0-9]*$/',
            'representation_active1' => 'required',
        ];

        $base_message = [
            'titre.required' => __("Le champ titre est requis"),
            'titre.regex' => __('Le titre doit avoir un nom valide'),
            'etat.required' => __('Le champ État est requis'),
            'etat.regex' => __('L\'état doit être d\'un format valide'),
            'code_postal.required' => __('Le champ code postal est requis'),
            'code_postal.regex' => __('Le code postal doit être un format valide'),
            'adresse.required' => __('Le champ adresse est requis'),
            'adresse.regex' => __('L\'adresse doit être un format valide'),
            'lien.required' => __('Le champ Lien est requis'),
            'lien.regex' => __('Le lien doit être un format valide'),
            'ville.required' => __('Le champ ville est requis'),
            'ville.regex' => __('La ville doit être valide'),
            'pays.required' => __('Le champ pays est requis'),
            'pays.regex' => __('Le pays doit être valide'),
            'categorie.required' => __('Le champ catégorie est requis'),
            'categorie.regex' => __('La catégorie doit être un format valide'),
            'prix_billet.required' => __('Le champ prix billet est requis'),
            'prix_billet.regex' => __('Le prix du billet doit être un format valide'),
            'date1.required' => __('Le champ date 1 est requis'),
            'date1.after_or_equal' => __('La date 1 doit être aujourd\'hui ou plus tard'),
            'nombre_billet1.required' => __('Le champ nombre de billet 1 est requis'),
            'nombre_billet1.regex' => __('Le nombre de billet 1 doit être un format valide'),
            'representation_active1.required' => __('La case représentation active 1 est requise')
        ];

        $array_inputs = $request->all();

        // vérifie s'il y a d'autre représentation
        if ((isset($array_inputs['date2']) && $array_inputs['date2'] != "") || (isset($array_inputs['nombre_billet2']) && $array_inputs['nombre_billet2'] != "")) {
            $base_inputs['date2'] = "required|after_or_equal:" . $date->format('Y-m-d H:i:s');
            $base_inputs['nombre_billet2'] = "required|regex:/^[0-9][0-9]*$/";
            $base_inputs['representation_active2'] = "regex:/.*/";

            $base_message['date2.required'] = __('Le champ date 2 est requis');
            $base_message['date2.after_or_equal'] = __('La date2 doit être aujourd\'hui ou plus tard');
            $base_message['nombre_billet2.required'] = __('Le champ nombre de billet 2 est requis');
            $base_message['nombre_billet2.regex'] = __('Le nombre de billet 2 doit être un format valide');
            $base_message['representation_active2.regex'] = "La case représentation active 2 doit être valide";
        }

        if ((isset($array_inputs['date3']) && $array_inputs['date3'] != "") || (isset($array_inputs['nombre_billet3']) && $array_inputs['nombre_billet3'] != "")) {
            $base_inputs['date3'] = "required|after_or_equal:" . $date->format('Y-m-d H:i:s');
            $base_inputs['nombre_billet3'] = "required|regex:/^[0-9][0-9]*$/";
            $base_inputs['representation_active3'] = "regex:/.*/";

            $base_message['date3.required'] = __('Le champ date 3 est requis');
            $base_message['date3.after_or_equal'] = __('La date3 doit être aujourd\'hui ou plus tard');
            $base_message['nombre_billet3.required'] = __('Le champ nombre de billet 3 est requis');
            $base_message['nombre_billet3.regex'] = __('Le nombre de billet 3 doit être un format valide');
            $base_message['representation_active3.regex'] = "La case représentation active 3 doit être valide";
        }

        //TODO ajouter le user
        $validation = Validator::make($request->all(), $base_inputs, $base_message);

        if ($validation->fails())
            return back()->withErrors($validation->errors())->withInput($request->input());

        $contenuFormulaire = $validation->validated();

        // modification dans la bd
        // TODO faire insertion avec table de jonction

        if ($contenuFormulaire['etat'] == 1 || $contenuFormulaire['etat'] == 2)
            $est_actif = 1;
        else
            $est_actif = 0;

        $evenement = Evenement::find($request->input('id_evenement'));
        $evenement->nom = $contenuFormulaire['titre'];
        $evenement->lieu = $contenuFormulaire['adresse'];
        $evenement->lien = $contenuFormulaire['lien'];
        $evenement->est_actif = $est_actif;
        $evenement->path_photo = 'bidon'; //TODO implémenter l'ajout d'une image
        $evenement->id_utilisateur = Auth::id();
        $evenement->id_statut = $contenuFormulaire['etat'];
        $evenement->id_ville = $contenuFormulaire['ville'];
        $evenement->id_categorie = $contenuFormulaire['categorie'];

        if ($evenement->save())
            $request->session()->now('succes', 'La modification de l\'événement a bien fonctionné.');
        else
            $request->session()->now('erreur', 'La modification l\'événement n\'a pas fonctionné.');


        // TODO mieux implémenter
        $date = $contenuFormulaire['date1'];
        $date = strtotime($date);

        $representation1 = Representation::find($request->input('id_representation1'));
        $representation1->date = date('Y-m-d', $date);
        $representation1->heure = date('H:i:s', $date);
        $representation1->nbr_places = ($contenuFormulaire['nombre_billet1'] >= $representation1->nbr_places ? $contenuFormulaire['nombre_billet1'] : $representation1->nbr_places);
        $representation1->est_actif = (isset($contenuFormulaire['representation_active1']) ? true : false);
        $representation1->prix = $contenuFormulaire['prix_billet'];
        $representation1->id_evenement = $evenement->id;

        $representation1->save();

        if ($array_inputs['date2'] != "") {
            $date = $contenuFormulaire['date2'];
            $date = strtotime($date);

            $representation2 = Representation::find($request->input('id_representation2'));
            if ($representation2 == null) {
                Representation::create([
                    'date' => date('Y-m-d', $date),
                    'heure' => date('H:i:s', $date),
                    'nbr_places' => $contenuFormulaire['nombre_billet3'],
                    'est_actif' => (isset($contenuFormulaire['representation_active3']) ? true : false),
                    'prix' => $contenuFormulaire['prix_billet'],
                    'id_evenement' => $evenement->id,
                ]);
            } else {
                $representation2->date = date('Y-m-d', $date);
                $representation2->heure = date('H:i:s', $date);
                $representation2->nbr_places = ($contenuFormulaire['nombre_billet2'] >= $representation2->nbr_places ? $contenuFormulaire['nombre_billet2'] : $representation2->nbr_places);
                $representation2->est_actif = (isset($contenuFormulaire['representation_active2']) ? true : false);
                $representation2->prix = $contenuFormulaire['prix_billet'];
                $representation2->id_evenement = $evenement->id;

                $representation2->save();
            }
        }

        if ($array_inputs['date3'] != "") {
            $date = $contenuFormulaire['date3'];
            $date = strtotime($date);

            $representation3 = Representation::find($request->input('id_representation3'));
            if ($representation3 == null) {
                Representation::create([
                    'date' => date('Y-m-d', $date),
                    'heure' => date('H:i:s', $date),
                    'nbr_places' => $contenuFormulaire['nombre_billet3'],
                    'est_actif' => (isset($contenuFormulaire['representation_active3']) ? true : false),
                    'prix' => $contenuFormulaire['prix_billet'],
                    'id_evenement' => $evenement->id,
                ]);
            } else {
                $representation3->date = date('Y-m-d', $date);
                $representation3->heure = date('H:i:s', $date);
                $representation3->nbr_places = ($contenuFormulaire['nombre_billet3'] >= $representation3->nbr_places ? $contenuFormulaire['nombre_billet3'] : $representation3->nbr_places);
                $representation3->est_actif = (isset($contenuFormulaire['representation_active3']) ? true : false);
                $representation3->prix = $contenuFormulaire['prix_billet'];
                $representation3->id_evenement = $evenement->id;

                $representation3->save();
            }
        }

        // envoie vers la page de confirmation
        return view('evenement/confirmation-modif-evenement', [
            'titre' => $contenuFormulaire['titre'],
            'etat' => $contenuFormulaire['etat'],
            'code_postal' => $contenuFormulaire['code_postal'],
            'adresse' => $contenuFormulaire['adresse'],
            'lien' => $contenuFormulaire['lien'],
            'ville' => $contenuFormulaire['ville'],
            'pays' => $contenuFormulaire['pays'],
            'categorie' => $contenuFormulaire['categorie'],
            'prix_billet' => $contenuFormulaire['prix_billet'],
            'date1' => $contenuFormulaire['date1'],
            'representation1' => $contenuFormulaire['nombre_billet1'],
            'actif1' => (isset($contenuFormulaire['representation_active1']) ? __("Oui") : __("Non")),
            'date2' => (isset($contenuFormulaire['date2']) ? $contenuFormulaire['date2'] : False),
            'representation2' => (isset($contenuFormulaire['nombre_billet2']) ? $contenuFormulaire['nombre_billet2'] : 0),
            'actif2' => (isset($contenuFormulaire['representation_active2']) ? __("Oui") : __("Non")),
            'date3' => (isset($contenuFormulaire['date3']) ? $contenuFormulaire['date3'] : False),
            'representation3' => (isset($contenuFormulaire['nombre_billet3']) ? $contenuFormulaire['nombre_billet3'] : 0),
            'actif3' => (isset($contenuFormulaire['representation_active3']) ? __("Oui") : __("Non")),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $evenement = Evenement::find($request->input('id_evenement'));

        $representations = Representation::where('id_evenement', '=', $evenement->id)
        ->get();

        $billets_vendus = 0;

        for ($i = 0; $i < count($representations); $i++) {
            $tbl_jonctions = Transaction_Representation::select('id')->where('id_representation', $representations[$i]->id)->get();

            $billets_vendus += Billet::whereIn('id_transaction_representation', $tbl_jonctions)->count();
        }

        #Doit ne pas avoir de billets vendus pour supprimer un evenement/rep.
        if ($billets_vendus == 0) {
            foreach ($representations as $representation)
                Representation::destroy($representation->id);
            if (Evenement::destroy($evenement->id))
                return back()->with('succes', 'La suppression de l\'événement a fonctionné.');
        }

        return back()->with('erreur', 'La suppression de l\'événement n\'a pas fonctionné. (Des billets sont déjà vendus)');
    }
}
