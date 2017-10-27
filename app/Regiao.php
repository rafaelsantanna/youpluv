<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regiao extends Model
{
    protected $table = "REGIOES";

    protected $fillable = ['descricao', 'latitude', 'longitude', 'raio', 'ativo'];

    public function usuario() {
        return $this->belongsTo('App\Usuario');
    }

    public function nascente() {
        return $this->belongsTo('App\Nascente');
    }
}
