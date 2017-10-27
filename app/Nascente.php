<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nascente extends Model
{
    protected $table = "NASCENTES";

    protected $fillable = ['descr_nascente', 'latitude', 'longitude', 'ativo', 'usuario_id', 'regiao_id'];

    public function usuario() {
        return $this->hasOne('App\Usuario');
    }

    public function regiao() {
        return $this->hasOne('App\Regiao');
    }
}
