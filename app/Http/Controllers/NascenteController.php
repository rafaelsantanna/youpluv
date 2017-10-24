<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Nascente;

class NascenteController extends Controller
{
    public function index()
    {
        $nascente = Nascente::all();
        return response()->json($nascente);
    }

    public function show($id)
    {
        $nascente = Nascente::find($id);
        
        if(!$nascente){
            return response()->json([
                'message' => 'Record not found',
                ], 404);
        }
        
        return response()->json($nascente);
    }
    
    public function store(Request $request)
    {
        $nascente = new Nascente();
        $nascente->fill($request->all());
        $nascente->save();
        
        return response()->json($request,201);
    }
    
    public function update(Request $request, $id)
    {
        $nascente = Nascente::find($id);
        
        if(!$nascente) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        
        $nascente->update($request->all());
        $nascente->save();
        
        return response()->json($nascente);
    }
    
    public function destroy($id)
    {
        $nascente = Nascente::find($id);
        
        if(!$nascente){
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        
        $nascente->delete();

        return response()->json("deletado com sucesso");
    }
}
