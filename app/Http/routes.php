<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
|
*/

get('/', 'WelcomeController@index');

/**
 * Rutas protegidas por Auth y Role
 * InfoController
 */	
Route::group(['as' => 'info::'], function(){
	get('form_certificado_pagos_profesionales', 
	[
		'uses' 			=> 'InfoController@form_certificado_pagos_profesionales',
		'as' 			=> 'form_certificado_pagos_profesionales'
		
	]);
	post('certificado_pagos_profesionales', 'InfoController@certificado_pagos_profesionales');

	get('form_pago_proveedores', 
	[
		'uses' 			=> 'InfoController@form_pago_proveedores',
		'as'			=> 'form_pago_proveedores'
		
	]);
	post('pago_proveedores', 'InfoController@pago_proveedores'); //Incluir la variable headerTitle en el controlador

	get('form_certificado_ica', 
	[
		'uses'			=> 'InfoController@form_certificado_ica',
		'as'			=> 'form_certificado_ica'
		
	]);
	post('certificado_ica', 'InfoController@certificado_ica'); //Se retiró 'info' del atributo action del formulario
	
	get('censo', 
	[
		'uses'			=> 'InfoController@censo',
		'as'			=> 'censo'
		
	]);


});


/*** UserController ***/

Route::group(['as' => 'usuarios::'], function(){
	
	get('usuarios', 
		[
			'uses'			=> 'UserController@index',
			'as'			=> 'usuarios',
			'permission'	=> 'ver_usuarios'
		]);

	get('registrar', 
	[
		'uses'			=> 'UserController@form_register',
		'as'			=> 'register',
		'permission' 	=> 'crear_usuarios'
	]);
	post('register', 'UserController@register');

	get('usuarios/{id}/edit', 
	[
		'uses'			=> 'UserController@edit',
		'as'			=> 'edit',
		'permission'	=> 'editar_usuarios'
	]);
	post('usuarios/{id}/update', 'UserController@update');

	get('usuarios/{id}/delete', 
	[
		'uses'			=> 'UserController@delete',
		'as'			=> 'delete',
		'permission'	=> 'eliminar_usuarios'
	]);
});

Route::group(['as' => 'permisos::'], function(){

	

	get('crear', 
	[
		'uses'			=> 'PermissionController@create',
		'as'			=> 'crear'
		
	]);

});

get('permisos', 'PermissionController@index');

//Route::get('usuarios/{id}/edit', 'UserController@edit');
//Route::get('usuarios/{id}/delete', 'UserController@delete');

//Route::resource('usuarios', 'UserController');

Route::get('censo/{p}', 'CensoController@censo');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);



