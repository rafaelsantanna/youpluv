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
        
        $id_device = $request->id_device;
        $email = $credentials['email'];

        $this->createIdDevice($id_device,$email);

        // all good so return the token
        return response()->json(compact('token'));
    }

    public function createIdDevice($id_device, $email){
        $fields = array( 
            'app_id' => "b2af917e-e731-437c-b6a2-f27a34760eba", 
            'identifier' => "$id_device", 
            'language' => "pt", 
            'timezone' => "-28800", 
            'game_version' => "1.0", 
            'device_os' => "6.0", 
            'device_type' => "1", 
            'device_model' => "XT1225", 
            'tags' => array("foo" => "bar") 
            ); 
            
            $fields = json_encode($fields); 
            
            $ch = curl_init(); 
            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/players"); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
            curl_setopt($ch, CURLOPT_HEADER, FALSE); 
            curl_setopt($ch, CURLOPT_POST, TRUE); 
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields); 
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
            
            $response = curl_exec($ch); 
            curl_close($ch); 

            //Pegando o retorno do Player_id enviado pelo OneSignal e armazenando no usuário
            $return = json_decode($response, true);
            $player_id = $return['id'];
            
//            dd($player_id);

            $usuario = Usuario::where('email', $email)->first();
            $usuario->update = (['id_device' => $player_id]);
            $usuario->save();
    }

}
