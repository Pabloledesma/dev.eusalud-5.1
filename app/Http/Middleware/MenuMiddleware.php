<?php

namespace App\Http\Middleware;

use Closure;
use Menu;
use Illuminate\Contracts\Auth\Guard;
use App\Role;
use App\User;
use App\Http\Controllers\Traits\Role\PermissionFunctions;


class MenuMiddleware
{
    
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Role implementation
     *
     * @var Role
     */
    protected $role;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth, Role $role) {
        $this->auth = $auth;
        $this->role = $role;
    }

    use PermissionFunctions;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        // Obtiene los permisos del rol
        $role = Role::findOrFail($this->auth->user()->role_id);
        $title_url = $this->get_role_perms_title_url( $role );
        $title_slug_url = $this->get_role_perms_title_slug_url( $role );
        // Se requiere consultar los permisos del rol que tienen el la palabra 
        //info en el slug para generar el menu de reportes
        dd($title_slug_url);

        Menu::make('start', function($menu) {
            $menu->add('Inicio', 'http://www.eusalud.com');
            if ($this->auth->check()) {

                if(isset($title_slug_url) && count( $title_slug_url ) > 0){
                    //$informes = $menu->add('Informes');
                    foreach($title_slug_url as $row){
                       foreach($row as $i){

                       }
                    }
                }

                $user = $menu->add($this->auth->user()->name);
                $user->add('Usuarios', 'usuarios')->data('permission', 'ver_usuarios');
                $user->add('Cerrar Sesión', ['action' => 'Auth\AuthController@getLogout']);
                
            } else {
                $menu->add('Iniciar Sesión', ['action' => 'Auth\AuthController@getLogin']);
                
            }
        });

        return $next($request);
    }
}
