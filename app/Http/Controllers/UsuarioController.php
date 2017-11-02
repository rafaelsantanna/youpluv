<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Hash;

use App\Usuario;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuario = Usuario::all();
        return response()->json($usuario);
    }

    public function show($id)
    {
        $usuario = Usuario::find($id);
        
        if(!$usuario){
            return response()->json([
                'message' => 'Record not found',
                ], 404);
        }
        
        return response()->json($usuario);
    }
    
    public function store(Request $request)
    {
        $usuario = new Usuario();
        $usuario->fill($request->all());
        $usuario->senha = Hash::make($request->senha);
        $usuario->save();
        
        return response()->json($request,201);
    }
    
    public function update(Request $request, $id)
    {
        $usuario = Usuario::find($id);
        
        if(!$usuario) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        
        $usuario->update($request->all());
        $usuario->save();
        
        return response()->json($usuario);
    }
    
    public function destroy($id)
    {
        $usuario = Usuario::find($id);
        
        if(!$usuario){
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        
        $usuario->delete();

        return response()->json("deletado com sucesso");
    }
}
