<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Role;
use App\DB\User\Traits\UserACL;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, UserACL;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password', 'num_id', 'user_type'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];
        
    /*
     * Check if the user is a team manager
     * @return boolean
     */
    public function isATeamManager()
    {
        $user = \Auth::user();
        if( $user->user_type == 'Super Admin' )
        {
            
            return true;
        } else {
            
            return false;
        }
    }

    /**
     * A user belongs to a role
     *
     * @return Relationship
     */
    public function role()
    {
    	return $this->belongsTo(Role::class);
    } 

}
