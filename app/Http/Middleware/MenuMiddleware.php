<?php

namespace App\Http\Middleware;

use Closure;
use Menu;
use Illuminate\Contracts\Auth\Guard;
use App\Role;


class MenuMiddleware
{
    
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth) {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        

        Menu::make('start', function($menu) {
            
            $menu->add('Inicio', 'http://www.eusalud.com');
            if ($this->auth->check()) {
                
                // Obtiene los permisos del rol
                $role = Role::findOrFail($this->auth->user()->role_id);
                $menu_info = [];    // Items del menú información
                $menu_ver = [];     // Items del menú ver
                
                // En el futuro se puede crear un objeto menu con categorias para evitar este bucle
                foreach($role->permissions as $permission){
                    if( stripos($permission->permission_slug, 'info_') === 0 ){
                        $menu_info += [ $permission->permission_title => $permission->permission_url];
                    }
                        
                    if( stripos($permission->permission_slug, "ver_") === 0 ){
                        $menu_ver += [ucfirst( str_replace("ver_", "", $permission->permission_slug) ) => $permission->permission_url];
                    }
                }
                
                if( count($menu_info) > 0 ){

                    // Si tiene permisos de administrador y de medico se elimina el item del medico
                    
                    
                    $informes = $menu->add( 'Informes' );
                    foreach( $menu_info as $title => $url ){
                        $informes->add( $title, $url );
                    }
                }

                $user = $menu->add($this->auth->user()->name);

                if( count($menu_ver) > 0 ){
                    
                    foreach( $menu_ver as $title => $url ){
                        $user->add( $title, $url );
                    }
                }

                $user->add('Cerrar Sesión', ['action' => 'Auth\AuthController@getLogout']);
                
            } else {
                $menu->add('Iniciar Sesión', ['action' => 'Auth\AuthController@getLogin']);
                
            }
        });

        return $next($request);
    }
}
