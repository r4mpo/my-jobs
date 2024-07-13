<?php

namespace App\Http\Middleware;

use App\Models\Users\Permission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class ValidatePermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $route = Route::currentRouteName();
        $list_routes_names_free = ['api.auth.login', 'api.auth.create'];
        
        if(!in_array($route, $list_routes_names_free)){
            $user = auth()->user();
            $permission = Permission::where('name', $route)->first();

            if($user && $permission)
            {
                $authorized = $user->can($permission->name);

                if(!$authorized){
                    throw new \Exception('unauthorized access route');
                }
            } else {
                throw new \Exception('user or permission invalid');
            }
        }

        return $next($request);
    }
}