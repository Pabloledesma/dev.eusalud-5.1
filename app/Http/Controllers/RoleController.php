<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Permission;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class RoleController extends Controller
{
    /**
     * Muestra una tabla con los Roles disponibles
     *
     * @return View
     */
    public function index()
    {
    	$roles = Role::all();
    	return view('role.index', compact('roles'));
    }

    /**
     * Obtiene todos los permisos existentes
     *
     * @return	Collection
     */  
    protected function getAllPermissions()
    {
    	return DB::table('permissions')->select('permission_title', 'permission_slug', 'id')->get();
    }

    /**
      * Muestra el formulario para crear un nuevo Rol
      *
      * @return	return
      */  
	public function create()
     {
     	$permissions = $this->getAllPermissions();

     	return view('role.create', compact('permissions'));
     }

    /**
	  * Crea un nuevo rol con los permisos asociados
	  *
	  * @param 	Request 	$request
	  * @return Redirect 
	  */
    public function store(Request $request)
    {
    	return $request->all();
    } 

    public function show()
    {
    	return;
    }
    /**
     * Muestra el formulario para editar el rol seleccionado
     *
     * @param	integer $role_id
     * @return	View
     */  
    public function edit($role_id)
    {
    	$role = Role::findOrFail($role_id);
    	$all_permissions = $this->getAllPermissions();
    	$role_permissions = $role->permissions;

    	$perm_role = [];		// Permisos agregados a este rol

    	foreach($role_permissions as $rp){
    		array_push($perm_role, $rp['attributes']['permission_title']);
    	}

    	return view('role.edit', compact('role', 'all_permissions', 'perm_role'));
    }

    /**
     * Obtiene los permisos seleccionados en el formulario
     *
     * @param    Request    $request
     * @return   Array      $seleccionados
     */  
    protected function getPermissionsFromRequest(Request $request)
    {
        $permissions_slug = DB::table('permissions')->select( 'permission_slug', 'id' )->get();
        $seleccionados = [];
        foreach( $permissions_slug as $ps )
        {
            if( $request->input( $ps->permission_slug ) )
            {
                $seleccionados +=  [ $ps->permission_slug => $ps->id ];
            }
        }
        
        return $seleccionados;
    }

    /**
      * Obtiene un arreglo asociativo los permisos del rol, si no tiene permisos
      * asociados, retorna false 
      *
      * @param    Role $role
      * @return   mixed   Array 
      */  
    protected function getRolePermissions(Role $role)
    {
        $role_permissions = $role->permissions;

        $perm_role_before = [];        // Permisos agregados a este rol anteriormente

        foreach($role_permissions as $rp){
            $perm_role_before += [ $rp['attributes']['permission_slug'] => $rp['attributes']['id']];
        }

        return $perm_role_before;
       
    }

    /**
     * Actualiza los permisos del rol
     *
     * @param    Array  $permissions
     * @param    Role   $role
     * @return   void
     */  
    protected function updateRolePermissions(Role $role, $permissions)
    {
        if(count($permissions) == 0){
            return "borrando los permisos";
        }

        return;
    }
    
      

    /**
     * Edita el Rol seleccionado
     *
     * @param	integer $role_id
     * @param 	Request $request 
     * @return	Redirect
     */   
    public function update($role_id, Request $request)
    {
    	$role = Role::findOrFail($role_id);
    	//dd($role);
        //dd($request->all());
        

        $selected = $this->getPermissionsFromRequest($request);
        $perm_role_before = $this->getRolePermissions($role);
        // Se modificaron los permisos?
        if( count($perm_role_before) == count($selected) && count( array_diff($perm_role_before, $selected) ) == 0 )
        {
            return "No hay cambios";
        }
        

    	$role->update( $request->all() );
    	
    	return redirect('roles');
    }

    public function destroy()
    {
    	return;
    } 

    
	  
      
}
