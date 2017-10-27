<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TabuaMaresDado extends Model
{
    protected $table = "TABUA_MARES_DADOS";

    protected $fillable = ['lua','data_hora', 'altura', 'ativo', 'tabua_mare_id'];

    public function tabuaMare() {
        return $this->hasOne('App\TabuaMare');
    }
}
