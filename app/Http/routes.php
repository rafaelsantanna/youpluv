<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Permite acessar a API de qualquer servidor.
header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

Route::get('/', function () {
    return response()->json(['message' => 'YouPluv API', 'status' => 'Connected']);;
});

Route::resource('/DadosPluv', 'DadosPluvController');
Route::resource('/Usuario', 'UsuarioController');
Route::resource('/TipoUsuario', 'TipoUsuarioController');
Route::resource('/Regiao', 'RegiaoController');
Route::resource('/Alerta', 'AlertaController');
Route::resource('/NivelAlerta', 'NivelAlertaController');
Route::resource('/TabuaMare', 'TabuaMareController');
Route::resource('/TabuaMaresDado', 'TabuaMaresDadoController');
Route::resource('/Nascente', 'NascenteController');

Route::post('/Login', 'LoginController@autenticar');

Route::get('/Weather', 'HelperController@getWeather');

Route::get('/getClassificacao', 'UsuarioController@getClassificacao');
Route::post('/redefinirSenha', 'UsuarioController@redefinirSenha');

Route::get('/dadosTabuaMare/{localID}{mes}{ano}', 'TabuaMaresDadoController@dadosTabuaMare');