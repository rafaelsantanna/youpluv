<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{
    protected $table = "TIPO_USUARIOS";

    protected $fillable = ['descricao', 'ativo'];

    public function usuario() {
        return $this->belongsToMany('App\Usuario');
    }

}
