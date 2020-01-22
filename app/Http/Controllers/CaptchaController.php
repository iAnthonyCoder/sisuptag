<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CaptchaController extends Controller
{
    public function create()
    {
        return view('captchacreate');
    }
    public function captchaValidate(Request $request)
    {
        
        
            $rules = ['captcha' => 'required|captcha'];
            $validator = validator()->make(request()->all(), $rules);
            if ($validator->fails()) {
              
                return response()->json(["denied" => true, "captcha" => '<p style="color: #ff0000;">Incorrect!</p>']);
            } else {
            
                return response()->json(["success" => true, "captcha" => '<p style="color: #00ff30;">Matched :)</p>']);
            }
    }
    public function refreshCaptcha()
    {
       
        $url=captcha_img();
       
        return response()->json(["success" => true, "captcha" => substr($url, 0)]);
      
    }
}
