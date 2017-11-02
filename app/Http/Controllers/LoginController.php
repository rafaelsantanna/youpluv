<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Hash;
use Cookie;

use App\Usuario;

class LoginController extends Controller
{
    public function autenticar(Request $request) {

        $credentials = $request->only('email', 'senha');

        $usuario = Usuario::where('email', $credentials['email'])->first();

        //Valida usuario
        if(!$usuario){
            return response()->json([
                'error' => 'Invalid credentials'
            ], 401);
        }
    
        //Valida Senha
        if(!Hash::check($credentials['senha'], $usuario->senha)){
            return response()->json([
                'error' => 'Invalid credentials'
            ], 401);
        }

        return response()->json('Logado!!');
    }

}
