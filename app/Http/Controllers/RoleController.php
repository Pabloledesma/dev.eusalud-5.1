<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Permission;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Muestra una lista de los roles disponibles
     *
     * @return Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    /**
     * Muestra el formulario para crear un rol
     *
     * @return Response
     */
    public function create()
    {
        $permissions = Permission::all();
        
        return view('roles.create', compact('permissions'));
    }

    /**
     * Almacena el nuevo role
     *
     * @return response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'role_title'    => 'required|min:3',
            'role_slug'     => 'required'
        ]);

        $permissions = Permission::all();
        $permissions_id = [];
        foreach($permissions as $perm){
            $permissions_id += [$perm->permission_slug => $perm->id];
        }

        $role = Role::create([
            'role_title'    => $request->input('role_title'),
            'role_slug'     => $request->input('role_slug')
        ]);

        // Asignación de permisos
        foreach($permissions_id as $key => $val){
            if( $request->has() )
        }

        flash()->overlay(
            'Los datos se guardaron exitosamente', 'Sistema'
        );

        return redirect('roles');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'role_title'    => 'required|min:3',
            'role_slug'     => 'required'
        ]);

        $input = $request->all();
        $role = Role::findOrFail($id);
        $role->update($input);
        flash()->overlay(
            'El Rol se actualizó exitosamente.', 'Sistema'
        );

        return redirect('roles');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        flash()->overlay(
            'El Rol se eliminó exitosamente.', 'Sistema'
        );

        return redirect('roles');
    }
}
