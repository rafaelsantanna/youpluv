<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = "USUARIOS";

    protected $fillable = ['nome', 'email', 'email', 'senha', 'num_celular', 'cep', 'endereco', 'complemento', 'numero', 'uf', 'municipio', 'lembrar_token', 'aut_alert', 'ativo', 'id_device', 'tipo_usuario_id', 'regiao_id'];
}
