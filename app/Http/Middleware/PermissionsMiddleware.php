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
        $afterSlash = explode('/', $request->path())[0];
        $basePath = explode('?', $afterSlash)[0];
        if (!Auth::check()) {
            return abort(401, "Pleas log back in to continue working...");
        }
        $user = Auth::user()->load('permissions');
        if ($basePath === 'search') {
            return $this->handleSearchController($request, $next);
        } else {
            foreach ($user->permissions as $permission) {
                if ($permission->mode->name == 'read' && $permission->type->slug == $basePath) {
                    return $next($request);
                }
            }
        }
        return $this->abortMessage();
    }

    private function handleSearchController($request, $next)
    {
        $modelPath = $request->get('value');
        $user = Auth::user()->load('permissions');
        foreach ($user->permissions as $permission) {
            if ($permission->mode->name == 'read' && $permission->type->slug == $modelPath) {
                return $next($request);
            }
        }
        return $this->abortMessage();

    }
    private function abortMessage()
    {
        return abort(403, 'Im sorry... You don\'t have permission to access this page...');
    }
}
