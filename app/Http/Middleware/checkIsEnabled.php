<?php

namespace App\Http\Middleware;

use Closure;

class checkIsEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (\Auth::check())
        {
            if (\Auth::User()->enabled != 1)
            {
                \Auth::logout();
                return redirect()->to('/login')->with('warning', 'Tu cuenta ha sido suspendida. Contacte al administrador.');
            }
        }

        return $next($request);
    }
}
