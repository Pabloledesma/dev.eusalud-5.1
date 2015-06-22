<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Permission;

class Role extends Model
{
    /**
     * A Role has many Users
     *
     * @return	Relationship
     */  
    public function users()
    {
    	return $this->hasMany(User::class);
    }

    /**
      * A Role can have many permissions
      *
      * @return	Relationship
      */  
    public function permissions()
    {
    	return $this->belongsToMany(Permission::class)->withTimeStamps();
    } 
     
      
    
}
