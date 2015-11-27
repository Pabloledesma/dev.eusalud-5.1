<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Permission;

class Role extends Model
{
    
    protected $fillable = ['name', 'lable'];

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
    	return $this->belongsToMany(Permission::class);
    }

    public function givePermissionTo(Permission $permission)
    {
      return $this->permissions()->save($permission);
    } 
    
}
