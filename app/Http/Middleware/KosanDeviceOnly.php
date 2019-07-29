<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class KosanDeviceOnly
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
		//$ua = $request->server('HTTP_USER_AGENT');
		//$ua = $ua? $ua :  $request->header('User-Agent');
		
		//if not kosan device user agent, abort
		if (!Str::contains($request->userAgent(), "Kosan Device")){
			abort(404, "Not Found");
		}
		
        return $next($request);
    }
}
