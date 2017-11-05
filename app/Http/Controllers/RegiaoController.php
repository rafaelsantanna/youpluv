<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Regiao;

class RegiaoController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.auth');
    }

    public function index()
    {
        $regiao = Regiao::all();
        return response()->json($regiao);
    }

    public function show($id)
    {
        $regiao = Regiao::find($id);
        
        if(!$regiao){
            return response()->json([
                'message' => 'Record not found',
                ], 404);
        }
        
        return response()->json($regiao);
    }
    
    public function store(Request $request)
    {
        $regiao = new Regiao();
        $regiao->fill($request->all());
        $regiao->save();
        
        return response()->json($request,201);
    }
    
    public function update(Request $request, $id)
    {
        $regiao = Regiao::find($id);
        
        if(!$regiao) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        
        $regiao->update($request->all());
        $regiao->save();
        
        return response()->json($regiao);
    }
    
    public function destroy($id)
    {
        $regiao = Regiao::find($id);
        
        if(!$regiao){
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        
        $regiao->delete();

        return response()->json("deletado com sucesso");
    }
}
