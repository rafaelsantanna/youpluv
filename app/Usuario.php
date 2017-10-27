<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = "USUARIOS";

    protected $fillable = ['nome', 'email', 'email', 'senha', 'num_celular', 'cep', 'endereco', 'complemento', 'numero', 'uf', 'municipio', 'lembrar_token', 'aut_alert', 'ativo', 'id_device', 'tipo_usuario_id', 'regiao_id'];

    public function tipoUsuario() {
        return $this->hasOne('App\TipoUsuario');
    }

    public function regiao() {
        return $this->hasOne('App\Regiao');
    }

    public function nascente() {
        return $this->belongsTo('App\Nascente');
    }

    public function dadosPluv() {
        return $this->belongsTo('App\DadosPluv');
    }

    public function alerta() {
        return $this->belongsTo('App\Alerta');
    }

}
