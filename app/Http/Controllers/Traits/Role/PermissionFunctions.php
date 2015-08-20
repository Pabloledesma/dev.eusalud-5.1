<?php
namespace App\Http\Controllers\Traits\Role;

use App\Http\Requests;
use App\Role;

trait PermissionFunctions {

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
     * Obtiene un arreglo con los id de los permisos del rol suministrado
     * Si no tiene permisos asociados retorna un arreglo vacio
     *
     * @param Role
     * @return Array 
     */
    public function get_role_perms_id(Role $role)
    {
        $role_perms = $role->permissions()->get()->toArray();
        $role_perms_id = [];

        foreach($role_perms as $perm){
            array_push($role_perms_id, $perm['id']);
        }

        return $role_perms_id;
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
      * Obtiene un arreglo asociativo con el titulo y el url de los permisos del rol suministrado
      *
      * @param Role $role
      * @return Array $title_url 
      */  
    public function get_role_perms_title_url(Role $role)
    {
    	$role_perms = $role->permissions()->get()->toArray();
        $title_url = [];

        foreach($role_perms as $perm){
            $title_url += [$perm['permission_title'] => $perm['permission_url']];
        }

        return $title_url;
    }

    /**
      * Obtiene un arreglo asociativo con el titulo y el slug de los permisos del rol suministrado
      *
      * @param Role $role
      * @return Array $title_slug 
      */  
    public function get_role_perms_title_slug(Role $role)
    {
        $role_perms = $role->permissions()->get()->toArray();
        $title_slug = [];

        foreach($role_perms as $perm){
            $title_slug += [$perm['permission_title'] => $perm['permission_slug']];
        }

        return $title_slug;
    } 

     /**
      * Obtiene un arreglo con el titulo, el slug y el url de los permisos del rol suministrado
      *
      * @param Role $role
      * @return Array $title_slug 
      */  
    public function get_role_perms_title_slug_url(Role $role)
    {
        $role_perms = $role->permissions()->get()->toArray();
        $title_slug_url = [];

        foreach($role_perms as $perm){
            array_push($title_slug_url, [
                'permission_title' => $perm['permission_title'], 
                'permission_slug' => $perm['permission_slug'], 
                'permission_url' => $perm['permission_url']
            ]);
        }

        return $title_slug_url;
    }   

}