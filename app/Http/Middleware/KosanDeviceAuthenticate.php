<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Device;

class KosanDeviceAuthenticate
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
		$token = $request->bearerToken();
		
		//if not provide bearer token, abort
		if (!$token){
			abort(404, "Not Found");
		}
		
		//find Device by bearer token
		//if not found, abort
		$device = Device::findByApiToken($token);
		if (!$device){
			abort(404, "Not Found");
		}
		
        return $next($request);
    }
}
