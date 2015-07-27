<?php
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CasosDeUsoTest extends TestCase 
{

	protected $baseUrl = '/';
	protected $usuario;
	protected $rol_admin;
	protected $permisos = [
		'Ver usuarios' 		=> 'ver_usuarios',
		'Editar Usuarios'	=> 'editar_usuarios',
		'Crear Usuarios'	=> 'crear_usuarios',
		'Eliminar Usuarios'	=> 'eliminar_usuarios',
		'Crear Permisos'	=> 'crear_permisos',
		'Ver Permisos'		=> 'ver_permisos',
		'Editar Permisos'	=> 'editar_permisos',
		'Eliminar Permisos'	=> 'eliminar_permisos',
		'Crear Roles'		=> 'crear_roles',
		'Ver Roles'			=> 'ver_roles',
		'Editar Roles'		=> 'editar_roles',
		'Eliminar Roles'	=> 'eliminar_roles'
	];


	use DatabaseTransactions;


	/**
	 * Crea un usuario
	 *
	 * @return void
	 */
	public function testCreaUsuario()
	{
		
		$this->usuario = factory(App\User::class)->create();

		$user = ['name' => $this->usuario->name, 'email' => $this->usuario->email];

		$this->seeInDatabase('users', $user);
		
	}

	/**
	  * Crea un Rol
	  *
	  * @return void
	  */ 
	public function testCreaRol()
	{
		$this->rol_admin = factory(App\Role::class)->create([
			'role_title' => 'Administrador del Sistema', 
			'role_slug' => 'admin_sis'
		]);

		$this->seeInDatabase(
			'roles', 
			[
				'role_title' => $this->rol_admin->role_title, 
				'role_slug' => $this->rol_admin->role_slug
			]);
	}

	/**
	  * Crea los permisos
	  *
	  * @return void
	  */
	public function testCreaPermisos()
	{
		foreach($this->permisos as $key => $val)
		{
			factory(App\Permission::class)->create([
				'permission_title' 	=> $key,
				'permission_slug'	=> $val
			]);
		}

		$this->seeInDatabase(
			'permissions', 
			[
				'permission_title' 	=> 'Ver Usuarios',
				'permission_slug'	=> 'ver_usuarios'
			]);
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