<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NivelAlerta extends Model
{
    protected $table = "NIVEL_ALERTAS";

    protected $fillable = ['descr_alerta', 'classificacao','cor', 'ativo'];
    
    public function alerta() {
        return $this->belongsToMany('App\Alerta');
    }
}
