<?php

namespace App\Http\Middleware;

use Closure;

class filter
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
        if (\Auth::user()->is_admin != 1)
		{
            
			abort(403, "No tienes autorización para ingresar.");
		}

		return $next($request);
	    
    }
}
