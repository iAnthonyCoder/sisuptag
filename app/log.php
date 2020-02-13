<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class log extends Model
{
    public $table = "log";
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
      public function getLoginAtAttribute(){
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['login_at'])->format('d-m-Y h:i:s');
      }
    //  public function getLogoutAtAttribute(){
    //    if($this->attributes['logout_at']==="0000-00-00 00:00:00")
    //    return "Expired";
    //    else
    //    return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['logout_at'])->format('d-m-Y h:i:s');
    //  }
}
