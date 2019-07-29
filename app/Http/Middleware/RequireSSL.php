<?php

namespace App\Http\Middleware;

use Closure;

class RequireSSL
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
		if (\App::environment("production")){
			
			if (!$request->secure()){
				abort(404);
			}
			
		}
        return $next($request);
    }
}
