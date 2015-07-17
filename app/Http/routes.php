<?php

/**
*|--------------------------------------------------------------------------
*| Rutas de la aplicación
*|--------------------------------------------------------------------------
*|
*|
*/

/*** 	PagesController ***/

Route::get('/', 'PagesController@index');
Route::get('quienes-somos', 'PagesController@about_us');
Route::get('vacantes', 'PagesController@vacantes');
Route::get('nuestras-clinicas/traumatologia', 'PagesController@sede_traumatologia');
Route::get('nuestras-clinicas/materno_infantil', 'PagesController@sede_materno_infantil');
Route::get('nuestras-clinicas/pacientes_cronicos', 'PagesController@sede_pacientes_cronicos');
Route::get('contacto', 'PagesController@contacto');
Route::post('contacto', 'PagesController@sendMsg');
Route::get('galeria', 'PagesController@galeria');

/*** InfoController ***/

Route::get('info', 'InfoController@index');
Route::get('info/form_certificado_pagos_profesionales', 'InfoController@form_certificado_pagos_profesionales');
Route::post('info/certificado_pagos_profesionales', 'InfoController@certificado_pagos_profesionales');
Route::get('info/pdf', 'InfoController@generatePdf'); //Esta ruta no existe !!!!
Route::get('info/form_pago_proveedores', 'InfoController@form_pago_proveedores');
Route::post('info/pago_proveedores', 'InfoController@pago_proveedores');
Route::get('info/form_certificado_ica', 'InfoController@form_certificado_ica');
Route::post('info/certificado_ica', 'InfoController@certificado_ica');
Route::get('info/censo', 'InfoController@censo');

/** RuafController **/
get('import_4505', 'RuafController@import');
post('resolucion_4505', 'RuafController@store');


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


/** RoleController **/

Route::resource('roles', 'RoleController');

//Route::resource('usuarios', 'UserController');

Route::get('censo/{p}', 'CensoController@censo');

Route::get('contactos', 'ContactController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

