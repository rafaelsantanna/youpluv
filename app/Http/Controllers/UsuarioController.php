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
        $this->middleware('jwt.auth', ['except' => ['store', 'getClassificacao', 'geocode']]);
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
        //Verificando se o email já existe  
        if(Usuario::where('email', $request->email)->first()){
            return response()->json([
                'message' => 'Email já existe'
            ], 409);
        }
        // este trecho serve para conseguir definir a região_id do usuário
        // primeiro conseguimos a latitude e longitude e depois rodamos a procedure para conseguir a regiao_id e armazenar no banco
        $endereco = $request->endereco . " " . $request->cep;
        $geoloc = $this->geocode($endereco);
        $lat = $geoloc['results'][0]['geometry']['location']['lat'];
        $lng = $geoloc['results'][0]['geometry']['location']['lng'];
        
        // este techo executa a procedure passando a latitude, longitude e raio 
        $regiao_id = DB::table('USUARIOS')->select(DB::raw("fn_findRegiaoIdByUserAddress('$lat', '$lng', '1.0') AS regiao_id"))->first();
        
        $usuario = new Usuario();
        $usuario->fill($request->all());
        $usuario->senha = Hash::make($request->senha);
        $usuario->regiao_id = $regiao_id->regiao_id;
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
        
            $endereco = $request->endereco . " " . $request->cep;
            $geoloc = $this->geocode($endereco);
            $lat = $geoloc['results'][0]['geometry']['location']['lat'];
            $lng = $geoloc['results'][0]['geometry']['location']['lng'];
            
            // este techo executa a procedure passando a latitude, longitude e raio 
            $regiao_id = DB::table('USUARIOS')->select(DB::raw("fn_findRegiaoIdByUserAddress('$lat', '$lng', '1.0') AS regiao_id"))->first();
            $usuario->update($request->all());
            //Fiz este foreach pra pegar somente o valor da regiao_id, pois não consegui pegar da forma normal (regiao_id[0])
            foreach ($regiao_id as $value) {
                $regiao_id = $value;
                break;
            }
            $usuario->regiao_id = $regiao_id;
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

    // retornando dados da api do google para capturar a longitude e altitude do endereço do usuário que acabou de se cadastrar
    public function geocode($endereco) {
        $enderecoFormatado = str_replace (" ", "+", $endereco);
        $details_url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $enderecoFormatado . "&key=AIzaSyB97YTHFUmjedJEvxqKv-nZAqvGt9plhlo&sensor=false";
     
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $details_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $geoloc = json_decode(curl_exec($ch), true);

        return $geoloc;
    }
}
