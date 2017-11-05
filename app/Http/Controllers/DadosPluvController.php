<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\DadosPluv;

class DadosPluvController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.auth');
    }

    public function index()
    {
        $dadosPluv = DadosPluv::all();
        return response()->json($dadosPluv);
    }

    public function show($id)
    {
        $dadosPluv = DadosPluv::find($id);
        
        if(!$dadosPluv){
            return response()->json([
                'message' => 'Record not found',
                ], 404);
        }
        
        return response()->json($dadosPluv);
    }
    
    public function store(Request $request)
    {
        $dadosPluv = new DadosPluv();
        $dadosPluv->fill($request->all());
        $dadosPluv->save();
        
        return response()->json($request,201);
    }
    
    public function update(Request $request, $id)
    {
        $dadosPluv = DadosPluv::find($id);
        
        if(!$dadosPluv) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        
        $dadosPluv->update($request->all());
        $dadosPluv->save();
        
        return response()->json($dadosPluv);
    }
    
    public function destroy($id)
    {
        $dadosPluv = DadosPluv::find($id);
        
        if(!$dadosPluv){
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        
        $dadosPluv->delete();

        return response()->json("deletado com sucesso");
    }
}
