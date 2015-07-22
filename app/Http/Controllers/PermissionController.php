<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;
use App\Http\Requests;
use App\Http\Requests\NewPermissionRequest;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    
    public function __construct()
    {
    	//$this->middleware('role:presidente');
    }

    /**
     * Muestra una tabla con los permisos creados
     *
     * @return response
     */
    public function index()
    {
    	$permisos = Permission::all();
        return view('permissions.index', compact('permisos'));
    }

    /**
     * Muestra el formulario para crear permisos
     *
     * @return response
     */
    public function create()
     {
     	return view('permissions.create');
     }


    /**
     * Valida y almacena un permiso
     *
     * @param   NewPermissionRequest $request
     * @return  response
     */
    public function store(NewPermissionRequest $request)
    {
        $permission = Permission::create([
            'permission_title'  => $request->input('permission_title'),
            'permission_slug'   => $request->input('permission_slug'),
            'permission_description'   => $request->input('permission_description')
        ]);

        flash()->overlay(
            'Los datos se guardaron exitosamente', 'Sistema'
        );

        return redirect('permisos');
    }

    /**
     * Muestra el formulario de edición de un permiso
     * 
     * @param Integer $permission_id
     * @return Response 
     */ 
    public function edit($permission_id)
    {
        $permission = Permission::findOrFail( $permission_id );
        return view('permissions.edit', compact('permission'));
    } 

}
