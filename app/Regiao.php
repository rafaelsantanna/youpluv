<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regiao extends Model
{
    protected $table = "REGIOES";

    protected $fillable = ['descricao', 'latitude', 'longitude', 'raio', 'ativo'];
}
