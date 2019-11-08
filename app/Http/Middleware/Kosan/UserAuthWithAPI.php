<?php

namespace App\Http\Middleware\Kosan;

use Closure;
use App\Models\User;
use App\Kosan\Service\AuthService;

class UserAuthWithAPI
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
		//get bearer token
		$bearerToken = $request->bearerToken();
		
		if (!$bearerToken || !AuthService::userLoginWithAPIToken($bearerToken)){
			return abort(401);
		}
		
        return $next($request);
    }
}
