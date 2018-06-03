<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class PermissionsMiddleware
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
        $basePath = explode('/', $request->path())[0];
        $user = Auth::user()->load('permissions');
        foreach ($user->permissions as $permission) {
            if ($permission->mode->name == 'read' && $permission->type->slug == $basePath) {
                return $next($request);
            }
        }
        return response()->json(['noPermissions' => true]);

    }
}
