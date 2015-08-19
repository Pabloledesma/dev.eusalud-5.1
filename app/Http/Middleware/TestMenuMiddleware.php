<?php

namespace App\Http\Middleware;

use Closure;
use Menu;
use Illuminate\Contracts\Auth\Guard;

class TestMenuMiddleware
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
                $user = $menu->add($this->auth->user()->name);
                    $user->add('Cerrar Sesión', ['action' => 'Auth\AuthController@getLogout']);
            } else {
                $menu->add('Iniciar Sesión', ['action' => 'Auth\AuthController@getLogin']);
            }
        });

        return $next($request);
    }
}
