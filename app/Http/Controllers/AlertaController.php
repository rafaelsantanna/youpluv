<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Usuario;
use App\Alerta;
use DB;

class AlertaController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.auth', ['except' => ['getAlertasUsuario', 'filtroAlertas']]);
    }

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
        
        //capturando o ID do alerta após a criação dele
        $last_id = DB::select('SELECT LAST_INSERT_ID()');
        $last_id = $last_id[0]->{'LAST_INSERT_ID()'};

        // armazenando o retorno da procedure que é um array que contém as regiões que o alerta vai afetar
        $regioes_do_alerta = DB::select("call vw_find_regioes_by_alerta_id($last_id)");
        
        $regiao_id = [];
        // este trecho armazena os ID das regiões em um array para posteriormente ser utilizada para buscar os usuários
        foreach ($regioes_do_alerta as $value) {
            array_push($regiao_id, $value->id);
        }
        
        // select na tabela usuário passando a regiao do usuário e armazenando todos os id_device dos usuários que estão naquela região
        // o pluck serve para pegar a lista de valores que eu defini para ele pegar neste caso id_device 
        $player_id = DB::table('USUARIOS')->whereIn('regiao_id', $regiao_id)->where('aut_alert', '1')->pluck('id_device');

        $titulo = $request->titulo;
        
        $this->sendMessage($titulo, $player_id);
        
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

    public function sendMessage($titulo, $player_id){
        $content = array(
            "en" => "English Message",
            "pt" => "$titulo"
            );
        
        $fields = array(
            'app_id' => "b2af917e-e731-437c-b6a2-f27a34760eba",
            'include_player_ids' => $player_id,
            'data' => array("foo" => "bar"),
            'contents' => $content
        );
        
        $fields = json_encode($fields);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                   'Authorization: Basic NGEwMGZmMjItY2NkNy0xMWUzLTk5ZDUtMDAwYzI5NDBlNjJj'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }

    // retorna os 10 ultimos alertas que o usuário recebeu
    public function getAlertasUsuario($usuario_id){

        if(!$usuario_id){
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        $alertas = DB::select("call pcd_find_alertas_by_usuario_id($usuario_id, 10);");

        return response()->json($alertas);
    }

    public function filtroAlertas(Request $request){
        $regiao_id = $request->regiao_id;
        $data_inicio = $request->data_inicio;
        $data_fim = $request->data_fim;

        $filtro = DB::select("call pcd_find_alertas_by_regiao_id($regiao_id,'$data_inicio','$data_fim');");

        return response()->json($filtro);
    }
}
