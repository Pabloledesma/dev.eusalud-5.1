<?php

namespace App\Http\Middleware;

use Closure;

class CheckPermission
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
        if(!$this->userHasAccessTo($request)){
          flash()->overlay('Comuniquese con el administrador del sistema', 'Acceso Denegado');
          return redirect('/');
        }

        return $next($request);
    }

    /**
     * Check if user has access to this requested route
     *
     * @param    \Illuminate\Http\Request $request
     * @return    Boolean true if has permission otherwise false
     */ 
    protected function userHasAccessTo($request)
    {
      return $this->hasPermission($request);
    } 

    /**
      * Check if user has requested route permission
      *
      * @param    \Illuminate\Http\Request $request
      * @return    Boolean true if has permission otherwise false
      */  
    
    protected function hasPermission($request)
    {
        $required = $this->requiredPermission($request);
        return !$this->forbiddenRoute($request) && $request->user()->can($required); 
    }

    /**
      * Extract required permission from requested route 
      *
      * @param    \Illuminate\Http\Request $request
      * @return    String permission_slug connected to the route
      */
    protected function requiredPermission($request)
    {
        $action = $request->route()->getAction();
        return isset($action['permission']) ? explode('|', $action['permission']) : null;
    }

    /**
      * Check if current route is hidden to the user role
      *
      * @param    \Illuminate\Http\Request $request
      * @return    Boolean true/false
      */
    protected function forbiddenRoute($request)
    {
        $action = $request->route()->getAction();
        if( isset($action['except']) ){
            return $action['except'] == $request->user()->role->role_slug;
        }
    }  

}
