<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Permission;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Role\PermissionFunctions;


class RoleController extends Controller
{
    
    use PermissionFunctions;

    /**
     * Todos los permisos creados
     * @var Array $permissions
     */
    protected $permissions;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('acl');
        $this->middleware('menu');
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

        $permissions_id = $this->get_all_perms_slug_id();
        
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
        $all_permissions = $this->permissions;
        $role_perms = $this->get_role_perms_slug_id( $role );
        $all_slug_id = $this->get_all_perms_slug_id();
        
        return view('roles.edit', compact('role', 'role_perms', 'all_permissions', 'all_slug_id'));
    }

    
    /**
     * Actualiza el rol seleccionado
     *
     * @param  Request $request
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
       
        // Identificar los permisos seleccionados
        $permisos_seleccionados = $this->get_selected_perms($request);

        // Verificar si esta enlazado el permiso
        $permisos_anteriores = $this->get_role_perms_id($role);

        //Si se modificaron los permisos
        if( count($permisos_seleccionados) != count($permisos_anteriores) ){
            
            // Si se agregaron permisos
            if( count($permisos_seleccionados) > count($permisos_anteriores) ){
                $role->permissions()->attach( array_diff($permisos_seleccionados, $permisos_anteriores) );
            }

            // Si se quitaron permisos
            if( count($permisos_seleccionados) < count($permisos_anteriores) ){
                $role->permissions()->detach(array_diff($permisos_anteriores, $permisos_seleccionados));
            }

        }

        $role->update($input);
        flash()->overlay(
            'El Rol se actualizó exitosamente.', 'Sistema'
        );

        return redirect('roles');

    }

   
    /**
     * Busca los permisos seleccionados en el formulario y retorna un arreglo con sus identificadores
     * Si no se seleccionó ningun permiso retorna un arreglo vacio
     *
     * @param Request $request
     * @return Array 
     */
    public function get_selected_perms(Request $request)
    {
        $input = $request->all();
        $permisos_seleccionados = [];
        foreach($input as $key => $val)
        {
            if(strlen($val) == 1 || strlen($val) == 2) array_push($permisos_seleccionados, $val);  
        }
        
        return $permisos_seleccionados;
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
