<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResource;


class PostController extends Controller
{
    public function index() //Afficher toutes les donées de la table catégorie
    {
        $post = Post::get(); 
       /* $retour = [
            "status" => true,
            "data" => $post
        ];
        return response()->json($retour, 200);*/
        return PostResource::collection($Posts);
    }

    public function show($id)
    {
        $post = Post::where("id", $id)->first();
        $retour = [
            "status" => true,
            "data" => $post
        ];
        return response()->json($retour, 200);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $post = Post::create([
            'titre' => $input['titre'],
            'contenu' => $input['contenu'],
            'user_id' => $input['user_id']
        ]);
      /*  $retour = [
            "status" => true,
            "data" => $post,
            "message" => "Element crée avec succès"
        ];*/
        //return response()->json($retour, 200);
        return new PostResource($post);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $post = Post::find($id);
        if(empty($post)){
            return response()->json(["message" => "Cette categorie n'existe pas"], 200);
        }
        $post->titre = $input["titre"];
        $post->contenu = $input["contenu"];
        $post->identifiant_utilisateur = $input["user_id"];
        $post->save();

        $retour = [
            "status" => true,
            "data" => $post,
            "message" => "Element mise à jour avec succès"
        ];
        return response()->json($retour, 200);
    }

    public function delete($id)
    {
        $post = Post::find($id);
        if(empty($post)){
            return response()->json(["message" => "Cette categorie n'existe pas"], 200);
        }
        $post->delete();
        $retour = [
            "status" => true,
            "description" => "Suppression effectuée"
        ];
        return response()->json($retour, 200);
    }
}
