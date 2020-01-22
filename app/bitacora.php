<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class bitacora extends Model
{
    protected $table = "bitacora";
    public function user()
    {
        return $this->belongsTo('App\user','user_id');
    }

    public function getCreatedAtAttribute(){
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->format('d-m-Y h:i:s');
      }
    
      public function getUpdatedAtAttribute(){
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['updated_at'])->format('d-m-Y h:i:s');
      }
    
}
