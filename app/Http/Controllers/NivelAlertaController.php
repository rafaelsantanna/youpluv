<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\NivelAlerta;

class NivelAlertaController extends Controller
{
    public function index()
    {
        $nivelAlerta = NivelAlerta::all();
        return response()->json($nivelAlerta);
    }

    public function show($id)
    {
        $nivelAlerta = NivelAlerta::find($id);
        
        if(!$nivelAlerta){
            return response()->json([
                'message' => 'Record not found',
                ], 404);
        }
        
        return response()->json($nivelAlerta);
    }
    
    public function store(Request $request)
    {
        $nivelAlerta = new NivelAlerta();
        $nivelAlerta->fill($request->all());
        $nivelAlerta->save();
        
        return response()->json($request,201);
    }
    
    public function update(Request $request, $id)
    {
        $nivelAlerta = NivelAlerta::find($id);
        
        if(!$nivelAlerta) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        
        $nivelAlerta->update($request->all());
        $nivelAlerta->save();
        
        return response()->json($nivelAlerta);
    }
    
    public function destroy($id)
    {
        $nivelAlerta = NivelAlerta::find($id);
        
        if(!$nivelAlerta){
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        
        $nivelAlerta->delete();

        return response()->json("deletado com sucesso");
    }
}
