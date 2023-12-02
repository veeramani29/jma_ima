<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
//use Illuminate\Support\Facades\Auth;

class AuthenticatedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        
		
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                
                return redirect()->guest('user/login?r=user/myaccount/subscription');
            }
        } 
		
		
        if (Auth::check()) 
            return $next($request);
		return redirect('/user/login?r=user/myaccount/subscription');
    }
}
