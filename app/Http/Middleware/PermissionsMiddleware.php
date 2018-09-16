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
        $user = Auth::user();
        if ($basePath === 'search') {
            return $this->handleSearchController($request, $next);
        } else {
            foreach ($user->permissions as $permission) {
                $permissionSlug = $permission->type->slug;
                if ($permission->mode->name == 'read' && $permissionSlug == $basePath 
                    // if the user can read permissions, they can read types and permission modes
                    || $basePath == 'types' && $permissionSlug == 'permissions'
                    || $basePath == 'permission-modes' && $permissionSlug == 'permissions'
                    // if the user can manage tasks, they can manipulate settings
                    || $basePath == 'settings' && $permissionSlug == 'tasks' && $permission->mode->name == 'manage') {
                    return $next($request);
                }
            }
        }
        return $this->abortMessage($basePath);
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
    private function abortMessage($path)
    {
        return abort(403, 'Im sorry... You don\'t have permission to access ' . $path . '...');
    }
}
