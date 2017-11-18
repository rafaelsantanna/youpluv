<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Hash;
use App\Usuario;

class LoginController extends Controller
{
    public function autenticar(Request $request) {

        // grab credentials from the request
        $credentials = $request->only('email', 'password');
        
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = app('tymon.jwt.auth')->attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        
        $email = $credentials['email'];
        $player_id = $request->userId;

        //Salvando o player_id do usuário no BD 
        $usuario = Usuario::where('email', $email)->first();
        $usuario->id_device = $player_id;
        $usuario->save();

        // armazenando o id do usuário para retornar para o front
        $id = $usuario->id;

        // all good so return the token and usuario->id
        return response()->json(compact('id','token'));
    }

}
