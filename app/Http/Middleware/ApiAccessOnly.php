<?php

namespace App\Http\Middleware;

use Closure;

class ApiAccessOnly
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
		if (!$request->wantsJson()){
			return abort(404);
		}
		
        return $next($request);
    }
}
