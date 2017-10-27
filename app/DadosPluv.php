<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DadosPluv extends Model
{
    protected $table = "DADOS_PLUVS";

    protected $fillable = ['latitude', 'longitude', 'hora_inicio', 'hora_fim', 'valor', 'usuario_id'];

    public function usuario() {
        return $this->hasOne('App\Usuario');
    }
}
