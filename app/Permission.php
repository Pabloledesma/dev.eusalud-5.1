<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Role;

class Permission extends Model
{
    
	protected $fillable = [
		'permission_title',
        'permission_slug',
		'permission_url',
		'permission_description'
	];

    /**
     * Permission can have multiple roles
     *
     * @return	Relationship
     */  
    public function roles()
    {
    	return $this->belongsToMany(Role::class)->withTimeStamps();
    } 
}
