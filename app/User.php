<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Exception;
//use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable {

	use EntrustUserTrait,Notifiable;
//	use SoftDeletes { restore as private restoreB; }

	//Big block of caching functionality.
	public function cachedRoles()
	{
		$userPrimaryKey = $this->primaryKey;
		$cacheKey = 'entrust_roles_for_user_'.$this->$userPrimaryKey;
		if(env('CACHE_DRIVER') <> 'redis'){
			$cache = Cache::store('array')->tags(Config::get('entrust.role_user_table'))->remember($cacheKey, Config::get('cache.ttl'), function () {
				return $this->roles()->get();
			});
		} else {
			$cache = Cache::tags(Config::get('entrust.role_user_table'))->remember($cacheKey, Config::get('cache.ttl'), function () {
				return $this->roles()->get();
			});
		}
		return $cache;
	}
	public function save(array $options = [])
	{   //both inserts and updates
		$result = parent::save($options);

		if(env('CACHE_DRIVER') <> 'redis'){
			Cache::store('array')->tags(Config::get('entrust.role_user_table'))->flush();
		} else {
			Cache::tags(Config::get('entrust.role_user_table'))->flush();
		}
		return $result;
	}
	public function delete(array $options = [])
	{   //soft or hard
		$result = parent::delete($options);

		if(env('CACHE_DRIVER') <> 'redis'){
			Cache::store('array')->tags(Config::get('entrust.role_user_table'))->flush();
		} else {
			Cache::tags(Config::get('entrust.role_user_table'))->flush();
		}
		return $result;
	}
	public function restore()
	{   //soft delete undo's
		$result = parent::restore();

		if(env('CACHE_DRIVER') <> 'redis'){
			Cache::store('array')->tags(Config::get('entrust.role_user_table'))->flush();
		} else {
			Cache::tags(Config::get('entrust.role_user_table'))->flush();
		}
		return $result;
	}

	public function can($permission, $requireAll = false)
	{
		if (is_array($permission)) {
			foreach ($permission as $permName) {
				$hasPerm = $this->can($permName);

				if ($hasPerm && !$requireAll) {
					return true;
				} elseif (!$hasPerm && $requireAll) {
					return false;
				}
			}

			// If we've made it this far and $requireAll is FALSE, then NONE of the perms were found
			// If we've made it this far and $requireAll is TRUE, then ALL of the perms were found.
			// Return the value of $requireAll;
			return $requireAll;
		} else {
			foreach ($this->cachedRoles() as $role) {
				// Validate against the Permission table
				foreach ($role->cachedPermissions() as $perm) {
					if (str_is( $permission, $perm->name) ) {
						return true;
					}
				}
			}
		}

		return false;
	}

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
	protected $fillable = ['name', 'email', 'password', 'leader','bakpw'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token','bakpw'];

	public static function fff()
	{
		return 'dsafdsaflkads';
	}
	/**
	 * @param $value
	 */
	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = bcrypt($value);
	}

	/**
	 * @return mixed
	 */
	public function getLevelMax()
	{
		$roles = [];
		foreach($this->roles as $role)
		{
			$roles[] = $role->level;
		}

		return max($roles);
	}

	public function  isAdmin(){
		return $this->roles()->get(['name'])->where('name','=','admin')->count();
	}

	public function getLeaderNameAttribute()
	{
		$leader = '';
		if ($this->leaderuser()->count()){
			$leader=$this->leaderuser()->getResults()->name;
		}
		return $leader;
	}

	public function getLikeAttribute()
	{
		$like = array_column(\DB::select('SELECT taskgroups.grade,count(taskgroups.grade) AS gcount FROM tasks INNER JOIN taskgroups ON taskgroups.task_id = tasks.id WHERE tasks.user_id = '.$this->id.' AND taskgroups.deleted_at IS NULL AND tasks.deleted_at IS NULL GROUP BY taskgroups.grade'),'gcount','grade');
		$like += [0=>0,1=>0,2=>0];
		return $like;
	}

	public function getTeams($leader,$team=[])
	{
		if (is_numeric($leader)) { $leader=[$leader]; }
		$lastTeam = array_column($this->whereIn('leader',array_keys($leader))->get()->toArray(),'name','id');//->where('id','<>',$leader)
//		\Log::debug('$team',$team);
		if ($lastTeam){
			$team += $lastTeam;
			$team = $this->getTeams($lastTeam,$team);
		}
		return $team;
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 **/
	public function leaderuser()
	{
		return $this->belongsTo(\App\User::class, 'leader', 'id');
	}

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public static $rules = [
		'email' => 'required|email',
	];

}
