<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class HelperController extends Controller
{
    //Controller para actions diversas

    //getWeather faz um get na api da hgbrasil e retorna o clima do Rio de Janeiro
    public function getWeather(){
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, "https://api.hgbrasil.com/weather/?format=json&city_name=Rio%20de%20Janeiro&key=223bb351"); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);   
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        
        $response = curl_exec($ch); 
        curl_close($ch);

        $return = json_decode($response);

        return response()->json($return->results);
    }
}
