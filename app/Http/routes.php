<?php

/**
*|--------------------------------------------------------------------------
*| Rutas de la aplicación
*|--------------------------------------------------------------------------
*|
*|
*/

get('/', 'PagesController@index');
get('/inicio', 'PagesController@index');
get('new_home', 'PagesController@index');

/**
 * Rutas protegidas por Auth y Role
 * InfoController
 */	
Route::group(['as' => 'info::'], function(){

	get('info', 'InfoController@index');

	/**** PROFESIONALES ****/

	get('form_certificado_pagos_profesionales_admin', 
	[
		'uses' 			=> 'InfoController@form_certificado_pagos_profesionales_admin',
		'as' 			=> 'form_certificado_pagos_profesionales_admin',
		'permission'	=> 'info_pagos_profesionales_administrador'
		
	]);

	get('form_certificado_pagos_profesionales', 
	[
		'uses' 			=> 'InfoController@form_certificado_pagos_profesionales',
		'as' 			=> 'form_certificado_pagos_profesionales',
		'permission'	=> 'info_pagos_profesionales'
		
	]);


	post('certificado_pagos_profesionales', 
		[
			'uses'			=> 'InfoController@certificado_pagos_profesionales',
			'as'			=> 'certificado_pagos_profesionales',
			'permission'	=> 'info_pagos_profesionales'
		]);

	/**** PROVEEDORES ****/

	get('form_pago_proveedores', 
	[
		'uses' 			=> 'InfoController@form_pago_proveedores',
		'as'			=> 'form_pago_proveedores',
		'permission'	=> 'info_pago_proveedores'
		
	]);

	get('form_pago_proveedores_admin', 
	[
		'uses' 			=> 'InfoController@form_pago_proveedores_admin',
		'as'			=> 'form_pago_proveedores_admin',
		'permission'	=> 'info_pago_proveedores_admin'
		
	]);

	post('pago_proveedores', 
	[
		'uses'			=> 'InfoController@pago_proveedores',
		'as'			=> 'pago_proveedores',
		'permission'	=> 'info_pago_proveedores'
	]); //Incluir la variable headerTitle en el controlador

	get('form_certificado_ica', 
	[
		'uses'			=> 'InfoController@form_certificado_ica',
		'as'			=> 'form_certificado_ica',
		'permission'	=> 'info_ica'
		
	]);

	get('form_certificado_ica_admin', 
	[
		'uses'			=> 'InfoController@form_certificado_ica_admin',
		'as'			=> 'form_certificado_ica_admin',
		'permission'	=> 'info_ica_admin'
		
	]);

	post('certificado_ica', 
	[
		'uses'			=> 'InfoController@certificado_ica',
		'as'			=> 'certificado_ica',
		'permission'	=> 'info_ica'
	]); //Se retiró 'info' del atributo action del formulario
	
	get('censo', 
	[
		'uses'			=> 'InfoController@censo',
		'as'			=> 'censo',
		'permission'	=> 'info_censo'
		
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
	post('register', 
	[
		'uses'			=> 'UserController@register',
		'as'			=> 'register',
		'permission'	=> 'crear_usuarios'
	]);

	get('usuarios/{id}/edit', 
	[
		'uses'			=> 'UserController@edit',
		'as'			=> 'edit',
		'permission'	=> 'editar_usuarios'
	]);

	post('usuarios/{id}/update', 
	[
		'uses'			=> 'UserController@update',
		'as'			=> 'update',
		'permission'	=> 'editar_usuarios'
	]);

	get('usuarios/{id}/delete', 
	[
		'uses'			=> 'UserController@delete',
		'as'			=> 'delete',
		'permission'	=> 'eliminar_usuarios'
	]);
});

/*** PermissionController ***/

get('permisos', 
	[
		'uses' 			=> 'PermissionController@index',
		'as'			=> 'permisos',
		'permission'	=> 'ver_permisos'
	]);

get('permisos/create', 
	[
		'uses'			=> 'PermissionController@create',
		'as'			=> 'create',
		'permission'	=> 'crear_permisos'
	]);

post('permisos/create', 
	[
		'uses'			=> 'PermissionController@store',
		'as'			=> 'create',
		'permission'	=> 'crear_permisos'
	]);

get('permisos/{id}/edit', 
	[
		'uses' 			=> 'PermissionController@edit',
		'as'			=> 'edit',
		'permission'	=> 'editar_permisos'
	]);

post('permisos/{id}/update', 
	[
		'uses'			=> 'PermissionController@update',
		'as'			=> 'update',
		'permission'	=> 'editar_permisos'
	]);

get('permisos/{id}/delete', 
	[
		'uses'			=> 'PermissionController@destroy',
		'as'			=> 'delete',
		'permission'	=> 'eliminar_permisos'
	]);

/*** RoleController ***/

get('roles', 
	[
		'uses' 			=> 'RoleController@index',
		'as'			=> 'roles',
		'permission'	=> 'ver_roles'
	]);

get('roles/create', 
	[
		'uses'			=> 'RoleController@create',
		'as'			=> 'create',
		'permission'	=> 'crear_roles'
	]);

post('roles/create', 
	[
		'uses'			=> 'RoleController@store',
		'as'			=> 'create',
		'permission'	=> 'crear_roles'
	]);

get('roles/{id}/edit', 
	[
		'uses'			=> 'RoleController@edit',
		'as'			=> 'edit',
		'permission'	=> 'editar_roles'
	]);

post('roles/{id}/update', 
	[
		'uses'			=> 'RoleController@update',
		'as'			=> 'update',
		'permission'	=> 'editar_roles'
	]);

get('roles/{id}/delete', 
	[
		'uses'			=> 'RoleController@destroy',
		'as'			=> 'delete',
		'permission'	=> 'eliminar_roles'
	]);

/*** CensoController(podria ser parte del infoController) ***/

Route::get('censo/{p}', 'CensoController@censo');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


