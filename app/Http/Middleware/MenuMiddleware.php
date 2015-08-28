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
     * Items del menú informativo
     *
     * @var array
     */
    protected $menu_info = [];

    /**
     * Items del menú de configuración
     *
     * @var array
     */
    protected $menu_ver = [];

 
    public function __construct(Guard $auth) {
        $this->auth = $auth;

        // Obtiene los permisos del rol
        $role = Role::findOrFail($this->auth->user()->role_id);
       
        foreach($role->permissions as $permission){
            if( stripos($permission->permission_slug, 'info_') === 0 ){
                $this->menu_info += [ $permission->permission_title => $permission->permission_url];
            }
                
            if( stripos($permission->permission_slug, "ver_") === 0 ){
                $this->menu_ver += [ucfirst( str_replace("ver_", "", $permission->permission_slug) ) => $permission->permission_url];
            }
        }
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
        

        Menu::make('left', function($menu) {
            
            // El link del inicio estará en el logo
            //$menu->add('Inicio', 'http://www.eusalud.com');
            if ($this->auth->check()) { 
                
                if( count($this->menu_info) > 0 ){

                    $informes = $menu->add( 'Informes' );
                    foreach( $this->menu_info as $title => $url ){
                        $informes->add( $title, $url );
                    }
                }
                
            }

            // Si no ha iniciado sesión, se carga automáticamente el formulario de inicio de sesión 
            // $menu->add('Iniciar Sesión', ['action' => 'Auth\AuthController@getLogin']);                
            
        });

        Menu::make('top', function($menu){

            if( $this->auth->check() ){

                $user = $menu->add($this->auth->user()->name);

                if( count($this->menu_ver) > 0 ){
                    
                    foreach( $this->menu_ver as $title => $url ){
                        $user->add( $title, $url );
                    }
                }

                $user->add('Cerrar Sesión', ['action' => 'Auth\AuthController@getLogout']);
            }
        });

        return $next($request);
    }
}
