<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nascente extends Model
{
    protected $table = "NASCENTES";

    protected $fillable = ['descr_nascente', 'latitude', 'longitude', 'ativo', 'usuario_id', 'regiao_id'];
}
