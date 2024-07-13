<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Http\Resources\CategorieResource;


class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::get();// SELECT * FROM CATEGORIE
       /* $retour = [
            "status" => true,
            "data" => $categories
        ];*/
        return CategorieResource::collection($categories);//tabeau d'objet => collection
        //return response()->json($retour, 200);
    }

    public function show($id)
    {
        $input = $request->all();
        //$categorie = Categorie::where("id", $id)->first();
        /*$retour = [
            "status" => true,
            "data" => $categorie
        ];*/
        //return response()->json($retour, 200);
        return new CategorieResource($categorie);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $categorie = Categorie::create([// enregistrer un table (insertinto)
            'nom' => $input['nom'],
            'description' => $input['description']
        ]);
        $retour = [
            "status" => true,
            "data" => $categorie,
            "message" => "Element crée avec succès"
        ];
        return response()->json($retour, 200);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $categorie = Categorie::find($id);
        if(empty($categorie)){
            return response()->json(["message" => "Cette categorie n'existe pas"], 200);
        }
        $categorie->nom = $input["nom"];
        $categorie->description = $input["description"];
        $categorie->save();

        $retour = [
            "status" => true,
            "data" => $categorie,
            "message" => "Element mise à jour avec succès"
        ];
        return response()->json($retour, 200);
    }

    public function delete($id)
    {
        $categorie = Categorie::find($id);
        if(empty($categorie)){
            return response()->json(["message" => "Cette categorie n'existe pas"], 200);
        }
        $categorie->delete();
        $retour = [
            "status" => true,
            "description" => "Suppression effectuée"
        ];
        return response()->json($retour, 200);
    }
}
