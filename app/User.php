<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Mail\Message;
use Mail;
use App\documento;
use App\log;

class User extends Authenticatable
{


  public function documentos()
  {
      return $this->hasMany('App\documento','modulos_id');
  }



  public function users()
  {
      return $this->hasMany('App\bitacora','user_id');
  }

  public function modulos()
  {
      return $this->belongsTo('App\modulo','modulos_id_u');
  }

  public function log()
  {
      return $this->hasMany('App\log','user_id');
  }

    public static function generatePassword()
    {
      // Generate random string and encrypt it.
      return bcrypt(str_random(35));
    }


    public static function sendWelcomeEmail($user)
    {
      // Generate a new reset password token
      $token = app('auth.password.broker')->createToken($user);

      // Send email
      Mail::send('emails.email', ['user' => $user, 'token' => $token], function ($m) use ($user) {
        $m->from('sisuptag@uptag.net', 'sisUptag');
        $m->to($user->email, $user->name)->subject('Bienvenido a sisUptag');
      });
    }





    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','last_login_at','last_login_ip','enabled',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
