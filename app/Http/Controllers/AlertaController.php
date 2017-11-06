<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Alerta;

class AlertaController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.auth');
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

        //Após salvar o alerta é executado o sendMessage que envia a notificação para o APP
        //Configurar a mensagem e os player_id que vão receber a mensagem

        function sendMessage(){
            $content = array(
                "en" => 'English Message'
                );
            
            $fields = array(
                'app_id' => "b2af917e-e731-437c-b6a2-f27a34760eba",
                'include_player_ids' => array("07b9ac31-8ce0-4365-9cba-b4fd2fb508bb", "4b1839d7-c441-41a9-b7f2-6082d0cd2902"),
                'data' => array("foo" => "bar"),
                'contents' => $content
            );
            
            $fields = json_encode($fields);
            print("\nJSON sent:\n");
            print($fields);
            
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
        
        $response = sendMessage();
        $return["allresponses"] = $response;
        $return = json_encode( $return);
        
        print("\n\nJSON received:\n");
        print($return);
        print("\n");
        
        // return response()->json($request,201);
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

    public function sendMessage(){
        $content = array(
            "en" => 'English Message'
            );
        
        $fields = array(
            'app_id' => "b2af917e-e731-437c-b6a2-f27a34760eba",
            'include_player_ids' => array("5f7c0d5ee1b22830","8e83b23e0bcc271", "dd6a76389a914784"),
            'data' => array("foo" => "bar"),
            'contents' => $content
        );
        
        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);
        
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
}
