<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    protected $table = "ALERTAS";

    protected $fillable = ['latitude', 'longitude', 'data_alerta', 'obs', 'ativo', 'usuario_id', 'nivel_alerta_id'];

    public function usuario() {
        return $this->hasOne('App\Usuario');
    }

    public function nivelAlerta() {
        return $this->hasOne('App\NivelAlerta');
    }
}
