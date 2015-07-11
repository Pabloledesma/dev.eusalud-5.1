<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
|
*/

/**
 * Rutas protegidas por Auth y ACL
 * InfoController
 */
Route::group(['as' => 'info::', 'middleware' => ['auth', 'acl']], function(){
	get('/', 'InfoController@index');
	get('form_certificado_pagos_profesionales', 
	[
		'uses' => 'InfoController@form_certificado_pagos_profesionales',
		'as' =>'form_certificado_pagos_profesionales', 
		'permission' => 'form_certificado_pagos_profesionales'
	]);
	post('certificado_pagos_profesionales', 'InfoController@certificado_pagos_profesionales');
	get('form_pago_proveedores', 'InfoController@form_pago_proveedores');
	post('pago_proveedores', 'InfoController@pago_proveedores'); //Incluir la variable headerTitle en el controlador
	get('form_certificado_ica', 'InfoController@form_certificado_ica');
	post('certificado_ica', 'InfoController@certificado_ica'); //Se retiró 'info' del atributo action del formulario
	get('censo', 'InfoController@censo');
});

Route::get('auth/register', ['middleware' => 'manager', function(){
    return view('auth.register');
}]);
Route::post('register', 'UserController@register');

/*** UserController ***/

//Restringir el uso de este recurso!!

//Route::get('usuarios', ['middleware' => 'manager', function(){
//    return view('user.index');
//}]);
Route::get('usuarios', 'UserController@index'); // Temporalmente

Route::post('usuarios/{id}/update', 'UserController@update');
Route::get('usuarios/{id}/edit', 'UserController@edit');
Route::get('usuarios/{id}/delete', 'UserController@delete');

//Route::resource('usuarios', 'UserController');

Route::get('censo/{p}', 'CensoController@censo');

Route::get('contactos', 'ContactController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);



get('permisos', 'PermissionController@index');