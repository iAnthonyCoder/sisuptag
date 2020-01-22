<?php

namespace App\Http\Controllers;
use Mail;
use Illuminate\Http\Request;

use Redirect,Response,DB,Config;
class EmailController extends Controller
{
    public function sendEmail()
    {
        $data['title'] = "This is Test Mail Tuts Make";
 
        Mail::send('emails.email', $data, function($message) {
 
            $message->to('tutsmake@gmail.com', 'Receiver Name')
 
                    ->subject('Tuts Make Mail');
        });
 
        if (Mail::failures()) {
     
           return json_encode(['Fail' => true, 'msg'=>"Sorry! Please try again latter"]);
         }else{
            return json_encode(['Success' => true, 'msg'=>"DONE"]);
         }
    }
}
