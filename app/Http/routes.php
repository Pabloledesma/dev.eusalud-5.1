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
 */
Route::group(['as' => 'info::', 'middleware' => ['auth', 'acl']], function(){
	get('/', 'InfoController@index');
	get('form_certificado_pagos_profesionales', 'InfoController@form_certificado_pagos_profesionales');
	post('certificado_pagos_profesionales', 'InfoController@certificado_pagos_profesionales');
	get('form_pago_proveedores', 'InfoController@form_pago_proveedores');
	post('pago_proveedores', 'InfoController@pago_proveedores');
});



/*** InfoController ***/


Route::post('info/pago_proveedores', 'InfoController@pago_proveedores');
Route::get('info/form_certificado_ica', 'InfoController@form_certificado_ica');
Route::post('info/certificado_ica', 'InfoController@certificado_ica');
Route::get('info/censo', 'InfoController@censo');


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