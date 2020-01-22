<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\log;

class logController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
       
    }
    public function index()
    {
        return view("logs");
    }

    public function indexGet()
    {

        $log=log::Join("users", "log.user_id","=","users.id")->where('log.session_token',"!=",session('_token'))->select('users.name','users.is_admin','log.login_at','log.logout_at','log.user_agent','log.id','log.ip_address', 'log.action')->get();
        return json_encode($log);
    }
}
