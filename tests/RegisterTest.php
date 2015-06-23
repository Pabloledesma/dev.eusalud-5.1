<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class RegisterTest extends TestCase
{
    

    protected $baseUrl = "http://dev.eusalud-5.1/";

    use DatabaseTransactions;

    
    /**
     * Prueba de Registro.
     *
     * @return void
     */
    public function test_crea_un_usuario_super_admin()
    {
        $user = factory(User::class)->create(["user_type" => "Super Admin"]);
        
        $this->seeInDatabase('users', ['email' => $user['attributes']['email']])
            ->visit('auth/login')
            ->type($user['attributes']['email'], 'email')
            ->type($user['attributes']['password'], 'password')
            ->press('Iniciar Sesión')
            ->seePageIs('/');
            
            
        
    }
}
