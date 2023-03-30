<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;
use DB;
use Laravel\Sanctum\PersonalAccessToken;




class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $utilisateur = DB::table('users')->paginate(15);
        return response()->json($utilisateur, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $id = auth('sanctum')->user()->id;
        
        DB::table('users')->where('id', $id)->delete();

        return response()->json([
            'message' => 'compte bien supprimé',
        ]);
    }
    public function InscriEtudiant(Request $request){
        $validator = Validator::make($request->all(),[
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'parcours' => 'string',
            'niveau' => 'string'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }
        $etudiant = new User;
        $etudiant->nom = $request->nom;
        $etudiant->prenom = $request->prenom;
        $etudiant->email =   $request->email;
        $etudiant->parcours =  $request->parcours;
        $etudiant->niveau =   $request->niveau;
        $etudiant->password  = bcrypt($request->password);
        $etudiant->save();

        return response()->json([
            'msg'=>'Bienvenu sur E-ZARA',
            'status_code'=>200,
            'etudiant'=>$etudiant,
        ]);

    }

    public function AuthentificationEtudiant(Request $request){
        try {
            $validator = Validator::make($request->all(),[
                'email' => 'email|required',
                'password' => 'required'
            ]);

            if($validator->fails()){
                return response()->json($validator->errors());
            }
            
            $req = request(['email', 'password']);
            
            if (!Auth::attempt($req)) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Mot de passe ou email non reconnu!'
            ]);
            }
            
            $user = User::where('email', $request->email)->first();
            
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            
            return response()->json([
                'msg'=>'connexion etablie',
                'status_code' => 200,
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
            ]);
            
        } catch (Exception $error) {
            return response()->json([
            'status_code' => 500,
            'message' => 'erreur de connexion',
            'error' => $error,
            ]);
        }
    }

    public function UpdateNomPrenom(Request $request){
        $validator = Validator::make($request->all(),[
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'niveau' => 'required|string|max:255',
            'parcours' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }


        $token = $request->bearerToken();
        $tokenresult = PersonalAccessToken::findToken($token);
        
        $id = auth('sanctum')->user()->id;

        $utilisateur = User::find($id);
        $utilisateur->nom = $request->nom;
        $utilisateur->prenom = $request->prenom;
        $utilisateur->email = $request->email;
        $utilisateur->niveau = $request->niveau;
        $utilisateur->parcours = $request->parcours;
        $utilisateur->save();

        return response()->json([
            'msg'=>'modification nom et prenom reussi',
            'status_code' => 200,
            'utilisateur'=> $utilisateur
            ]);       
    }

    public function UpdatePassword(Request $request){
        $validator = Validator::make($request->all(),[
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',

        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $token = $request->bearerToken();
        $tokenresult = PersonalAccessToken::findToken($token);
        
        $id = auth('sanctum')->user()->id;

        $utilisateur = User::find($id);        
        $utilisateur->password = bcrypt($request->password);
        $utilisateur->save();

        return response()->json([
            'msg'=>' Nouveau Mot de passe',
            'status_code' => 200,
            'utilisateur'=> $utilisateur
            ]);
    }

    public function password_resset(Request $request){

        $validator = Validator::make($request->all(),[
            'email' => 'required|string|email'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $user = DB::table('users')->where('email', $request->email)->get();
        $pin = rand(10000,99999);

        if(count($user)>0){        
            return response()->json([
                'code_pin' => $pin
            ]);
        }else{
            return response()->json([
                'msg' => 'email no reconnu'
            ]);
        }

    }

    public function myInfo(Request $request){

        $token = $request->bearerToken();
        $tokenresult = PersonalAccessToken::findToken($token);
        $user = $tokenresult->tokenable;

        return response()->json($user, 200);

    }

    public function updateImage(Request $request){
        
        $validator = Validator::make($request->all(),[
            'url' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $id = auth('sanctum')->user()->id;
        
        //$store = Storage::disk('local')->put('arjunphp_laravel.png', file_get_contents($url));

        $contents = file_get_contents($request->url);
        $name = substr($request->url, strrpos($request->url, '/') + 1);
        $store = Storage::put($name, $contents);


        $utilisateur = User::find($id);
        $utilisateur->image = $request->$store;
        $utilisateur->save();

        return response()->json([
            'msg' => 'image download'
        ]);
    }

    public function getOneUser(Request $request, $id){
        
        /*$us = DB::table('users')->where('id', $id);
        
        $user = User::where('id', $request->id)->first();

        $utilisateur = User::find($id);

        return response()->json([
            'msg' => $user,
            'att' => $utilisateur,
            'us' => $us
        ]);*/

        return response()->json(200);

    }

}

