<?php

namespace App;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use App\modulo;
use App\User;
use Request;
class documento extends Model
{

    protected $table="documentos";
    protected $fillable = [
        'description','modulos_id','dirlocal'
    ];

    public function modulo()
    {
        return $this->belongsTo('App\modulo','modulos_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function documentosUser()
    {
        return $this->belongsTo('App\User','user_id')->select(array("nombre"));
    }
    public function generic_request()
    {

          return Redirect::to('login')->with('message', 'your message');


    }

//     public function getFechaAttribute($fecha)
// {

//     return Carbon::parse($fecha)->toFormattedDateString();
// }


}
