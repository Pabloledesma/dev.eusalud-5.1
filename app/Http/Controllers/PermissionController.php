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
    	$this->middleware('auth');
        $this->middleware('acl');
        $this->middleware('menu');
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
        $this->validate($request, [
                'permission_title'  => 'required|min:3',
                'permission_slug'   => 'required|min:3'
            ]);

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

    /**
     * Actualiza el permiso seleccionado
     *
     * @param  Request $request
     * @param  int  $permission_id
     * @return Response
     */

    public function update(Request $request, $permission_id)
    {
        
        $this->validate($request, [
                'permission_title'  => 'required|min:3',
                'permission_slug'   => 'required|min:3'
            ]);
        $permission = Permission::findOrFail( $permission_id );
        $input = $request->all();
        $permission->update( $input );
        flash()->overlay(
            'El Permiso se actualizó exitosamente.', 'Sistema'
        );
        return redirect('permisos');
    }

    /**
     * Elimina el permiso seleccionado
     *
     * @param   int $permission_id
     * @return  response
     */  
    public function destroy($permission_id)
    {
        $permission = Permission::findOrFail( $permission_id );
        $permission->delete();
        flash()->overlay(
            'El Permiso se eliminó exitosamente.', 'Sistema'
        );
        return redirect('permisos');
        
    } 
}
