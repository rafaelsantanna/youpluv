<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\TipoUsuario;

class TipoUsuarioController extends Controller
{
    public function index()
    {
        $tipoUsuario = TipoUsuario::all();
        return response()->json($tipoUsuario);
    }

    public function show($id)
    {
        $tipoUsuario = TipoUsuario::find($id);
        
        if(!$tipoUsuario){
            return response()->json([
                'message' => 'Record not found',
                ], 404);
        }
        
        return response()->json($tipoUsuario);
    }
    
    public function store(Request $request)
    {
        $tipoUsuario = new TipoUsuario();
        $tipoUsuario->fill($request->all());
        $tipoUsuario->save();
        
        return response()->json($request,201);
    }
    
    public function update(Request $request, $id)
    {
        $tipoUsuario = TipoUsuario::find($id);
        
        if(!$tipoUsuario) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        
        $tipoUsuario->update($request->all());
        $tipoUsuario->save();
        
        return response()->json($tipoUsuario);
    }
    
    public function destroy($id)
    {
        $tipoUsuario = TipoUsuario::find($id);
        
        if(!$tipoUsuario){
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        
        $tipoUsuario->delete();

        return response()->json("deletado com sucesso");
    }
}
