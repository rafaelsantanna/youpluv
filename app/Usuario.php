<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Usuario extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    protected $table = "USUARIOS";

    protected $fillable = ['nome', 'email', 'senha', 'num_celular', 'cep', 'endereco', 'complemento', 'numero', 'uf', 'municipio', 'lembrar_token', 'aut_alert', 'ativo', 'id_device', 'tipo_usuario_id', 'regiao_id'];

    public function getAuthPassword()
    {
        return $this->senha;
    }

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
        return $this->belongsToMany('App\DadosPluv');
    }

    public function alerta() {
        return $this->belongsTo('App\Alerta');
    }

}
