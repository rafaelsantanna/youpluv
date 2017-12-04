<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\DadosPluv;

use DB;

class DadosPluvController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.auth', ['except' => ['getRegistroUsuario', 'filtroDadosPluvs']]);
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

    public function getRegistroUsuario($usuario_id){
        
        if(!$usuario_id){
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        
        $registrosUsuario = DB::table('DADOS_PLUVS')->where('usuario_id', $usuario_id)->limit(20)->orderBy('id','desc')->get();
        return response()->json($registrosUsuario);
    }

    public function getRegistroTresDias() {
        $registros = DB::table('DADOS_PLUVS')->whereRaw('created_at >= DATE_SUB(NOW(), INTERVAL 72 HOUR)')->get();

        return response()->json($registros);
    }

    public function filtroDadosPluvs(Request $request) {
        $regiao_id = $request->regiao_id;
        $data_inicio = $request->data_inicio;
        $data_fim = $request->data_fim;

        //Retorna sem nenhum Filtro
        if(!$regiao_id && !$data_inicio && !$data_fim) {
            $filtro = DB::select("select * from vw_dados_pluv");
        }

        //retorna filtrando por data somente
        if(!$regiao_id && $data_inicio != null && $data_fim != null){
            $filtro = DB::select("select * from vw_dados_pluv where hora_inicio BETWEEN '$data_inicio' and '$data_fim'");
        }

        //retorna filtrando por região somente
        if($regiao_id != null && !$data_inicio && !$data_fim){
            $filtro = DB::select("select * from vw_dados_pluv where regiao_id = $regiao_id");
        }

        //retorna filtrando região e data
        if($regiao_id != null && $data_inicio != null && $data_fim != null ){
            $filtro = DB::select("select * from vw_dados_pluv where regiao_id = $regiao_id and hora_inicio BETWEEN '$data_inicio' and '$data_fim'");
        }
        return response()->json($filtro);
    }
}
