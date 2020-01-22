<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Log;
use App\User;
use Carbon\Carbon;
use Session;

class LogSuccessfulLogout
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {


        
        //$tok=$event->user->last_login_ip;
       /* $login = $login = new Log;
        $login->user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        $login->session_token = session('_token');
        $login->ip_address = $_SERVER['REMOTE_ADDR'];
        $login->logout_at = \Carbon\Carbon::now();  
       
        $login->action = "SuccessfulLogout";*/
 
        
        //$user->is_active=0;
        //$Log = Log::find($tok);
        //$Log->logout_at = Carbon::now();
        


        // $Log = $event->user->log()->where('session_token', session('_token'))->first();
        // $Log->logout_at=carbon::now();
       
        // $Log->save();
        

    }
}
