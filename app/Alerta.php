<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    protected $table = "ALERTAS";

    protected $fillable = ['latitude', 'longitude','raio', 'data_alerta', 'usuario_id', 'nivel_alerta_id', 'titulo', 'mensagem', 'ativo'];

    public function usuario() {
        return $this->hasOne('App\Usuario');
    }

    public function nivelAlerta() {
        return $this->hasOne('App\NivelAlerta');
    }
}
