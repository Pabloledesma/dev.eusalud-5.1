<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Role;

class Permission extends Model
{
    
	protected $fillable = [
		'name',
        'label'
	];

    /**
     * Permission can have multiple roles
     *
     * @return	Relationship
     */  
    public function roles()
    {
    	return $this->belongsToMany(Role::class);
    } 
}
