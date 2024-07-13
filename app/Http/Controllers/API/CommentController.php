<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::get();
        $retour = [
            "status" => true,
            "data" => $categories
        ];
        return response()->json($retour, 200);
    }

    public function show($id)
    {
        $comment = Comment::where("id", $id)->first();
        $retour = [
            "status" => true,
            "data" => $comment
        ];
        return response()->json($retour, 200);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $comment = Comment::create([
            'nom' => $input['nom'],
            'contenu' => $input['contenu'],
            'id_post' => $input['id_post'],
            'id_user' => $input['id_user']
        ]);
        $retour = [
            "status" => true,
            "data" => $comment,
            "message" => "Element crée avec succès"
        ];
        return response()->json($retour, 200);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $comment = Comment::find($id);
        if(empty($comment)){
            return response()->json(["message" => "Ce commentaire n'existe pas"], 200);
        }
        $categorie->nom = $input["nom"];
        $categorie->contenu = $input["contenu"];
        $categorie->id_post = $input["id_post"];
        $categorie->id_user = $input["id_user"];
        $categorie->save();

        $retour = [
            "status" => true,
            "data" => $comment,
            "message" => "Element mise à jour avec succès"
        ];
        return response()->json($retour, 200);
    }

    public function delete($id)
    {
        $comment = Comment::find($id);
        if(empty($comment)){
            return response()->json(["message" => "Ce commentaire n'existe pas"], 200);
        }
        $comment->delete();
        $retour = [
            "status" => true,
            "description" => "Suppression effectuée"
        ];
        return response()->json($retour, 200);
    }

}
