<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param   String $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role = null)
    {
        if(!$request->user()->hasRole($role)){
            flash()->overlay(
                'Permisos insuficientes para usar este recurso', 
                'Acceso Denegado'
            );
            return redirect('/');
        }
        return $next($request);
    }
}
