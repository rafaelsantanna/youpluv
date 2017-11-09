<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    protected $table = "ALERTAS";

    //regiao, nivel alerta, mensagem, titulo
    protected $fillable = ['mensagem', 'titulo', 'ativo', 'regiao_id', 'usuario_id', 'nivel_alerta_id'];

    public function usuario() {
        return $this->hasOne('App\Usuario');
    }

    public function nivelAlerta() {
        return $this->hasOne('App\NivelAlerta');
    }

    public function regiao(){
        return $this->hasOne('App\Regiao');
    }
}
