<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\documento;

class modulo extends Model
{
    protected $table="modulos";
    protected $fillable = [
        'nombre'
    ];


    public function documentos()
    {
        return $this->hasMany('App\documento','modulos_id');
    }
    public function users()
  {
      return $this->hasMany('App\User','modulos_id_u');
  }


}
