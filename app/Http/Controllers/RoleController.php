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
     * Todos los permisos creados
     * @var Array $permissions
     */
    protected $permissions;

    public function __construct()
    {
        $this->permissions = Permission::all()->toArray();
    }

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
        $permissions = $this->permissions;
        
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

        $permissions_id = $this->get_perm_slug_id();
        
        $role = Role::create([
            'role_title'    => $request->input('role_title'),
            'role_slug'     => $request->input('role_slug')
        ]);

        // Asignación de permisos
        foreach($permissions_id as $key => $val){
            if( $request->has($key) ){
                $role->permissions()->attach($val);
            }
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
        $all_perms = $this->permissions;
        $role_perms = $this->get_role_perms_slug_id( $role );
        $all_slug_id = $this->get_all_perms_slug_id();
        
        return view('roles.edit', compact('role', 'role_perms', 'all_perms', 'all_slug_id'));
    }

    /**
     * Obtiene un arreglo asociativo con el slug y el id de todos los permisos existentes
     *
     * @return Array $slug_id
     */
    public function get_all_perms_slug_id()
    {
        $slug_id = [];
        foreach($this->permissions as $perm){
            $slug_id += [$perm['permission_slug'] => $perm['id']];
        }
        return $slug_id;
    }

    /**
     * Obtiene un arreglo asociativo con el slug y el id de los permisos del rol suministrado
     *
     * @param Role $role
     * @return Array $slug_id
     */
    public function get_role_perms_slug_id(Role $role)
    {
        $role_perms = $role->permissions()->get()->toArray();
        $slug_id = [];

        foreach($role_perms as $perm){
            $slug_id += [$perm['permission_slug'] => $perm['id']];
        }

        return $slug_id;
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
