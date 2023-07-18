<?php
//allo hihihi
namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use App\Http\Resources\CategorieResource;
use Illuminate\Support\Facades\Validator;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->routeIs('LstCategoriesApi')){
            return CategorieResource::collection(Categorie::All());
        }
        return view('categorie/categories', [
        // D’autres paramètres peuvent être passés à la vue en les séparant par une virgule.
        'categories' => Categorie::All(),"user"=>Auth::user()
        ]);


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( Request $request)
    {
        $validation = Validator::make($request->all(), [
            'nom' => 'required|max:255',
            'description' => 'required|max:250',
        ], [
            'nom.required' => __('Veuillez entrer un nom.'),
            'nom.max'=>__('Veuillez ne doit pas depasser 255 caractères.'),
            'message.required' => __('Veuillez inscrire une question ou un commentaire.'),
            'message.max' => __('Votre question ou commentaire ne peut pas dépasser 255 caractères.')
        ]);

        if ($validation->fails())
            return back()->withErrors($validation->errors())->withInput();

        $contenuFormulaire = $validation->validated();

        // On crée une nouvelle instance du modèle (de la classe) "Commentaire"
        $categorie = Categorie::create([
                'nom'=>$contenuFormulaire['nom'],
                'description'=>$contenuFormulaire['description'],
                'est_actif'=>true,
        ]);

        if ($categorie)
            return response()->json(new CategorieResource($categorie), 200);

        return response()->json(['erreur' => __('La categorie n\'a pas ete cree')], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $idcategorie, Request $request)
    {
        if ($request->routeIs('categorieApi')) {
            $validatedData = Validator::make($request->all(), [
                'id' => 'required|integer|min:1',
            ], [
                'id.required' => __('Veuillez entrer un identifiant de catégorie.'),
                'id.integer' => __('L\'identifiant de catégorie doit être un nombre entier.'),
                'id.min' => __('L\'identifiant de catégorie doit être supérieur ou égal à 1.'),
            ]);
            if ($validatedData->fails()){
                return back()->withErrors($validatedData->errors())->withInput();
            }
            $id = $validatedData->validated();
            $categorie = Categorie::find($id['id']);

            if (empty($categorie))
                return response()->json(['ERREUR' => __('Le produit demandé est introuvable.')], 400);

            return new CategorieResource($categorie);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request , Categorie $categorie)
    {
        $id = $request->input('id');
        $categorie= Categorie::find($id);

        return view('categorie/formulaireCategorie', [
            'categorie' => $categorie
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Categorie $categorie)
    {
        if($request->routeIs('enregistrementCategorie')){
            $categorie = Categorie::find($request->categorie);

            if ($categorie) {
                $categorie->nom = $request->nom;
                $categorie->description = $request->description;
                $categorie->save();
                if ($categorie->save())
                    return response()->json(['SUCCES', __('La modification de la categorie a bien fonctionné.')], 200);
                else
                    return response()->json(['ERREUR', __('La modification de la categorie n"a pas fonctionné.')], 400);

            }
            else {
                return response()->json(['ERREUR'=> __('La categorie n\'existe pas.')],400);
            }
        }
        if ($request->routeIs('modificationCategorieApi')){
            $validatedData = Validator::make($request->all(), [
                'id' => 'required|integer|min:1',
                'nom' => 'required|max:255',
                'description' => 'required|max:250'
            ], [
                'id.required' => __('Veuillez entrer un id.'),
                'id.integer' => __('L\'id doit être un nombre entier.'),
                'id.min' => __('L\'id doit être supérieur ou égal à 1.'),
                'nom.required' => __('Veuillez entrer un nom.'),
                'nom.max'=>__('Veuillez ne doit pas depasser 255 caractères.'),
                'message.required' => __('Veuillez inscrire une question ou un commentaire.'),
                'message.max' => __('Votre question ou commentaire ne peut pas dépasser 255 caractères.')
            ]);
            // Trouver la catégorie à mettre à jour
            if ($validatedData->fails()){
                return back()->withErrors($validatedData->errors())->withInput();
            }
            $contenu = $validatedData->validated();
            $categorie = Categorie::find($contenu['id']);

            if (!$categorie) {
                return response()->json(['message' =>__('La categorie n\'esiste pas.') ], 404);
            }

            // Mettre à jour les champs de la catégorie
            $categorie->nom = $contenu['nom'];
            $categorie->description = $contenu['description'];

            $categorie->save();
            if ($categorie->save()) {
                return response()->json(['SUCCES', __('La modification de la categorie a bien fonctionné.') ,'id'=> $categorie->id,'nom' => $categorie->nom, 'description' => $categorie->description], 200);
            }else {
                 return response()->json(['ERREUR', __('La modification de la categorie n\'a pas fonctionné.')],400);
            }

        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if ($request->routeIs('suppressionCategorieApi')){
            $validatedData = Validator::make($request->all(), [
                'categorie' => 'required|integer|min:1',
            ], [
                'categorie.required' => __('Veuillez entrer une categorie.'),
                'categorie.integer' => __('La categorie doit être un nombre entier.'),
                'categorie.min' => __('La categorie doit être supérieure ou égale à 1.'),
            ]);
            if ($validatedData->fails()){
                return back()->withErrors($validatedData->errors())->withInput();
            }
            $id = $validatedData->validated();
            if(Categorie::destroy($id['categorie'])){
                return response()->json(['message'=> __('La categorie est supprimé.')],200);
            }
            return response()->json(['message'=>__('La categorie est introuvable ')],400);

        }
        if($request->routeIs('suspensionCategorieApi')){
            $validatedData = Validator::make($request->all(), [
                'id' => 'required|integer|min:1'
            ], [
                'id.required' => __('Veuillez fournir l\'ID de la catégorie.'),
                'id.integer' => __('L\'ID de la catégorie doit être un nombre entier.'),
                'id.min' => __('L\'ID de la catégorie doit être supérieur ou égal à 1.')
            ]);
            if($validatedData->fails()){
                return back()->withErrors($validatedData->errors())->withInput();
            }
            $id = $validatedData->validated();
            $categorie = Categorie::find($id['id']);
            if ($categorie->est_actif == 1) {
                $categorie->est_actif = 0;
                $message = __('La categorie a été reactivée avec succes.');
            }
            else{
                $categorie->est_actif = 1;
                $message = __('la categorie a été suspendue avec succes.');
            }
            $categorie->save();
            return response()->json(['message'=>$message, 'categorie'=>$categorie],200);
        }

        if ($request->routeIs('suppressionCategorie')) {
            $id = $request->categorie;
            if (Categorie::destroy($id))
                return response()->json(['SUCCES'=> __('La suppression de la categorie a bien fonctionné.')],200);
            else
                return response()->json(['ERREUR'=> __('La suppression de la categorie n\'a pas fonctionné.') ],400);
        }

        if ($request->routeIs('suspensionCategorie')) {
            $validation = Validator::make($request->all(), [
                'categorie' => 'required|integer|min:1'
            ], [
                'categorie.required'=> __('L\'id choisit est pas le bon'),
                'categorie.integer' => __('L\'ID de la catégorie doit être un nombre entier.'),
                'categorie.min' => __('L\'ID de la catégorie doit être supérieur ou égal à 1.')
            ]);

            if ($validation->fails()){
                return back()->withErrors($validation->errors())->withInput();
            }

            $contenuFormulaire = $validation->validated();

            $id = $contenuFormulaire["categorie"];

            $categorie = Categorie::find($id);

            if ($categorie->est_actif == 1) {
                $categorie->est_actif = 0;

                if ($categorie->save())
                    return response()->json(['SUCCES' => __("La categorie a bien ete suspendu.")], 200);
                else
                    return response()->json(['ERREUR' => __("La categorie n'a pas ete suspendu.")], 500);
            }
            else if ($categorie->est_actif == 0) {
                $categorie->est_actif = 1;

                if ($categorie->save())
                    return response()->json(['SUCCES' => __("La categorie a bien ete reactive.")], 200);
                else
                    return response()->json(['ERREUR' => __("La cetegorie n'a pas ete reactive.")], 500);
            }
        }
    }

    public function search(Request $request){
         $validatedData = Validator::make($request->all(), [
            'recherche' => 'string|max:255',
         ], [
            'recherche.string' => __('La recherche doit être une chaîne de caractères.'),
            'recherche.max' => __('La recherche ne doit pas dépasser 255 caractères.'),
        ]);
        if ($validatedData->fails()) {
            return back()->withErrors($validatedData->errors())->withInput();
        }

        $recherche =$request->input('recherche');
        $categories=Categorie::where('nom','LIKE','%'.$recherche.'%')->get();

        return view('categorie.categories',compact('categories'));
    }
}
