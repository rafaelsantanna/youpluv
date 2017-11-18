<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Hash;

use DB;
use App\DadosPluv;
use App\Usuario;

class UsuarioController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.auth', ['except' => ['store', 'getClassificacao']]);
    }

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
        
        return response()->json($usuario, 201);
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

    // retorna o nome e o numero de vezes que o usuário já enviou dados pluviométricos
    public function getClassificacao() {
        $classificacao = DB::table('USUARIOS')->select('USUARIOS.nome', DB::raw('count(DADOS_PLUVS.usuario_id) as numero'))
        ->join('DADOS_PLUVS', function($join){
            $join->on('USUARIOS.id', '=', 'DADOS_PLUVS.usuario_id');
        })->groupBy('usuario_id')->orderBy('numero', 'desc')->limit(10)->get();

        return response()->json($classificacao);
    }

    public function redefinirSenha(Request $request){
        $usuario = Usuario::find($request->id);

        if(!$usuario){
            return response()->json([
                'message' => 'Record not found'
            ], 404);
        }

        if(Hash::check($request->senha, $usuario->senha)){
            $usuario->senha = Hash::make($request->newSenha);
            $usuario->save();

            return response()->json($usuario, 201);
        }else {
            return response()->json([
                'message' => 'Senha Incorreta'
            ], 404);
        }
    }
}
