<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Permission;

class Role extends Model
{

    /**
      * A Role can have many permissions
      *
      * @return	Relationship
      */  
    public function permissions()
    {
    	return $this->belongsToMany(Permission::class)->withTimeStamps();
    }

    public function givePermissionTo(Permission $permission)
    {
      return $this->permissions()->save( $permission );
    } 
    
}
