<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\TabuaMaresDado;

class TabuaMaresDadoController extends Controller
{
    public function index()
    {
        $tabuaMareDado = TabuaMaresDado::all();
        return response()->json($tabuaMareDado);
    }

    public function show($id)
    {
        $tabuaMareDado = TabuaMaresDado::find($id);
        
        if(!$tabuaMareDado){
            return response()->json([
                'message' => 'Record not found',
                ], 404);
        }
        
        return response()->json($tabuaMareDado);
    }
    
    public function store(Request $request)
    {
        $tabuaMareDado = new TabuaMaresDado();
        $tabuaMareDado->fill($request->all());
        $tabuaMareDado->save();
        
        return response()->json($request,201);
    }
    
    public function update(Request $request, $id)
    {
        $tabuaMareDado = TabuaMaresDado::find($id);
        
        if(!$tabuaMareDado) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        
        $tabuaMareDado->update($request->all());
        $tabuaMareDado->save();
        
        return response()->json($tabuaMareDado);
    }
    
    public function destroy($id)
    {
        $tabuaMareDado = TabuaMaresDado::find($id);
        
        if(!$tabuaMareDado){
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        
        $tabuaMareDado->delete();

        return response()->json("deletado com sucesso");
    }
}
