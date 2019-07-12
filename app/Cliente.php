<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public function endereco(){
    	$this->hasOne('App\Endereco');
    }
}
