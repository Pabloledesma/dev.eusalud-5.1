<?php 

namespace App\DB\User\Traits;

trait UserACL 
{
	/**
	 * Can checks a permission
	 *
	 * @param	String $perm Name of a permission
	 * @return	Boolean true if has permission
	 */
	public function can($perm = null)
	{
		if($perm){
			return $this->checkPermission( $this->getArray($perm) );
		}
		return false;
	}

	/**
	  * Make string to array if already not
	  *
	  * @param	Mixed String/array $perm
	  * @return	array
	  */
	 protected function getArray($perm)
	 {
	 	return is_array($perm) ? $perm : explode('|', $perm);
	 }

	/**
	   * Check if the permission matches with any permission user has
	   *
	   * @param		Array $perm Name of a permission (one or more separated with |)
	   * @return	Boolean true if permission exists
	   */ 
	protected function checkPermission($permArray = [])
	{
		$perms = $this->role->permissions->fetch('permission_slug');
		$perms = array_map('strtolower', $perms->toArray());

		return count( array_intersect($perms, $permArray) ); 
	}

	/**
	  * Check if has a permission (same as 'can')
	  *
	  * @param		Array $perm Name of a permission (one or more separated with |)
	  * @return Boolean true if has permission, otherwise false
	  */
	public function hasPermission( $perm = null )
	{
		return $this->can($perm);
	}

	/**
	  * Check if has a role
	  *
	  * @param 	String $role role_slug
	  * @return Boolean true if has permission, otherwise false
	  */
	public function hasRole($role = null)
	{
		if(is_null($role)) return false;
		
		if(!isset($this->role->role_slug)){
			flash()->overlay(
				'El usuario no tiene rol asignado, por favor pongase en contacto con el administrador',
				'Error!'
			);
			return false;
		}

		return strtolower($this->role->role_slug) == strtolower($role); 
	}

	/**
	 * Check if user has given role
	 * 
	 * @param 	String $role role_slug
	 * @return  Boolean 
	 */
	public function is($role)
	{
		return $this->role->role_slug == $role;
	} 


	/**
    * Check if user has permission to a route
    *
    * @param  String $routeName
    * @return Boolean true/false
    */
	public function hasRoute($routeName)
	{
		$route = app('router')->getRoutes()->getByName($routeName);
			if($route) {
				$action = $route->getAction();
				if(isset($action['permission'])) {
					$array = explode('|', $action['permission']);
					return $this->checkPermission($array);
				}
			}
		return false;
	}

/**
    * Check if a top level menu is visible to user
    *
    * @param  String $perm
    * @return Boolean true/false
    */
	public function canSeeMenuItem($perm)
	{
		return $this->can($perm) || $this->hasAnylike($perm);
	}

   /**
    * Checks if user has any permission in this group
    *
    * @param  String $perm Required Permission
    * @param  Array $perms User's Permissions
    * @return Boolean true/false
    */

	protected function hasAnylike($perm)
	{
		$parts = explode('_', $perm);
		$requiredPerm = array_pop($parts);
		$perms = $this->role->permissions->fetch('permission_slug');
		foreach ($perms as $perm)
		{
		 if(ends_with($perm, $requiredPerm)) return true;
		}

		return false;
	}

}