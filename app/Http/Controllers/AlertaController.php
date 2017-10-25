<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Alerta;

class AlertaController extends Controller
{
    public function index()
    {
        $alerta = Alerta::all();
        return response()->json($alerta);
    }

    public function show($id)
    {
        $alerta = Alerta::find($id);
        
        if(!$alerta){
            return response()->json([
                'message' => 'Record not found',
                ], 404);
        }
        
        return response()->json($alerta);
    }
    
    public function store(Request $request)
    {
        $alerta = new Alerta();
        $alerta->fill($request->all());
        $alerta->save();
        
        return response()->json($request,201);
    }
    
    public function update(Request $request, $id)
    {
        $alerta = Alerta::find($id);
        
        if(!$alerta) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        
        $alerta->update($request->all());
        $alerta->save();
        
        return response()->json($alerta);
    }
    
    public function destroy($id)
    {
        $alerta = Alerta::find($id);
        
        if(!$alerta){
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        
        $alerta->delete();

        return response()->json("deletado com sucesso");
    }
}
