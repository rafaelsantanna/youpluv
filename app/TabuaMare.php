<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TabuaMare extends Model
{
    protected $table = "TABUA_MARES";

    protected $fillable = ['descricao', 'ativo'];
}
