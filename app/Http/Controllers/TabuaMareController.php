<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\TabuaMare;

class TabuaMareController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.auth');
    }

    public function index()
    {
        $tabuaMare = TabuaMare::all();
        return response()->json($tabuaMare);
    }

    public function show($id)
    {
        $tabuaMare = TabuaMare::find($id);
        
        if(!$tabuaMare){
            return response()->json([
                'message' => 'Record not found',
                ], 404);
        }
        
        return response()->json($tabuaMare);
    }
    
    public function store(Request $request)
    {
        $tabuaMare = new TabuaMare();
        $tabuaMare->fill($request->all());
        $tabuaMare->save();
        
        return response()->json($request,201);
    }
    
    public function update(Request $request, $id)
    {
        $tabuaMare = TabuaMare::find($id);
        
        if(!$tabuaMare) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        
        $tabuaMare->update($request->all());
        $tabuaMare->save();
        
        return response()->json($tabuaMare);
    }
    
    public function destroy($id)
    {
        $tabuaMare = TabuaMare::find($id);
        
        if(!$tabuaMare){
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        
        $tabuaMare->delete();

        return response()->json("deletado com sucesso");
    }

}
