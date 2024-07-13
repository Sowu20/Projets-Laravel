<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get();
        $retour = [
            "status" => true,
            "data" => $users
        ];
       
        return response()->json($retour, 200);
    }

    public function show($id)
    {
        $user = User::where("id", $id)->first();
        $retour = [
            "status" => true,
            "data" => $user
        ];
        return response()->json($retour, 200);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $password = Hash::make($input['password']); //Pour crypter le mot de passe qui sera enregistré


        $user = User::create([
            'nom' => $input['nom'],
            'prenom' => $input['prenom'],
            'email' => $input['email'],
            'password' =>$password 
        ]);
       /* $retour = [
            "status" => true,
            "data" => $user,
            "message" => "Utilisateur enregistré avec succès"
        ];
        return response()->json($retour, 200);*/
        //return UserResource::collection($user)

        return response()->json([
            "success"=>true,
            "data" => $user,
            "message" => "Utilisateur enregistré avec succès"    
        ]);

    }
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $user = User::find($id);
        if(empty($user)){
            return response()->json(["message" => "Cet utilisateur n'existe pas"], 200);
        }
        $user->nom = $input["nom"];
        $user->prenom = $input["prenom"];
        $user->email = $input["email"];
        $user->password = $input["password"];
        $user->save();

        $retour = [
            "status" => true,
            "data" => $user,
            "message" => "Element mise à jour avec succès"
        ];
        return response()->json($retour, 200);
    }

    public function delete($id)
    {
        $user = User::find($id);
        if(empty($user)){
            return response()->json(["message" => "Cet utilisateur n'existe pas"], 200);
        }
        $user->delete();
        $retour = [
            "status" => true,
            "description" => "Suppression effectuée"
        ];
        return response()->json($retour, 200);
    }

    public function login(Request $request)
    {
        // Pour appliquer des règles de validation sur les champs
        $validatedData = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);


        ///Vérification des identifiants si c'est correcte ou pas.
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return response()->json(["message" => "Identifiant ou mot de passe incorrecte"]);
        }


        $user = Auth::user(); //Pour recupérer l'utilisateur dont les identifiants correspondent


        //Création du Token
        $device_name = isset($request->device_name) ? $request->device_name : 'myApp';
        $user->token =  $user->createToken($device_name)->plainTextToken;
        ///////////////////////////
       
        return ["success" => true,
                "data" => $user,
                "message" => 'Connexion effectuée avec succès'];
        // return $this->sendResponse(new UserResource($user), 'Connexion effectuée avec succès');
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['success' => true, 'message' => 'Déconnecté avec succès']);
    }


    private function getValidationRules()
    {
        return [
            'email' => 'required|email|min:5',
            'password' =>'required|min:3',
        ];
    }





}
