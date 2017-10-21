<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\TipoUsuario;

class TipoUsuarioController extends Controller
{
    public function index()
    {
        $tipoUsuario = TipoUsuario::all();
        return response()->json($tipoUsuario);
    }
}
