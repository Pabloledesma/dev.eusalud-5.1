<?php
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CasosDeUsoTest extends TestCase 
{

	protected $baseUrl = '/';
	protected $usuario;

	
	/**
	 * Crea un usuario
	 *
	 * @return void
	 */
	public function testCreaUsuario()
	{
		$this->usuario = App\User::create([
			'name' => 'TestUser',
			'email' => 'test@test.com',
			'password' => '123456'
		]);

		$this->assertTrue(!is_null($this->usuario));

		dd(App\Role::first()); 
	} 

	/**
	 * Inicio de la aplicación
	 *
	 * @return void
	 */
	public function testInicioApp()
	{
		$this->visit('/')
			->see('Iniciar Sesión');
	}

}