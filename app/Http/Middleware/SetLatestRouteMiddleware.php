<?php

namespace App\Http\Middleware;

use Closure;

class SetLatestRouteMiddleware
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
        if(user() && !user('password_confirmed') && request()->ajax()){
            abort(402, 'Set your new password to start working.');
        }
/*         if(user()){
            user()->last_route = '/'.explode('/', $request->fullPath())[0];
            user()->save();
        } */
        return $next($request);
    }
}
