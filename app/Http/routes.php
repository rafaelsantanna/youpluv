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

// Route::group(array('prefix' => 'api'), function()
// {

//   Route::get('/', function () {
//       return response()->json(['message' => 'YouPluv API', 'status' => 'Connected']);;
//   });

//   //   Route::resource('companies', 'CompaniesController');
//   Route::resource('TipoUsuario', 'TipoUsuarioController');
// });

// Route::get('/', function () {
//     return redirect('api');
// });

Route::get('/TipoUsuario', 'TipoUsuarioController@index');