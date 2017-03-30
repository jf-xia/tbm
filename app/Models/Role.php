<?php

namespace App\Models;

use Zizaco\Entrust\EntrustRole;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;

class Role extends EntrustRole {

	/**
	 * @var array
	 */
	protected $fillable = ['name', 'display_name', 'description', 'level'];

	//Big block of caching functionality.
	public function cachedPermissions()
	{
		$rolePrimaryKey = $this->primaryKey;
		$cacheKey = 'entrust_permissions_for_role_'.$this->$rolePrimaryKey;

		if(env('CACHE_DRIVER') <> 'redis'){
			$cache = Cache::store('array')->tags(Config::get('entrust.permission_role_table'))->remember($cacheKey, Config::get('cache.ttl'), function () {
				return $this->perms()->get();
			});
		} else {
			$cache = Cache::tags(Config::get('entrust.permission_role_table'))->remember($cacheKey, Config::get('cache.ttl'), function () {
				return $this->perms()->get();
			});
		}
		return $cache;
	}
	public function save(array $options = [])
	{   //both inserts and updates
		$result = parent::save($options);

		if(env('CACHE_DRIVER') <> 'redis'){
			Cache::store('array')->tags(Config::get('entrust.permission_role_table'))->flush();
		} else {
			Cache::tags(Config::get('entrust.permission_role_table'))->flush();
		}
		return $result;
	}
	public function delete(array $options = [])
	{   //soft or hard
		$result = parent::delete($options);

		if(env('CACHE_DRIVER') <> 'redis'){
			Cache::store('array')->tags(Config::get('entrust.permission_role_table'))->flush();
		} else {
			Cache::tags(Config::get('entrust.permission_role_table'))->flush();
		}
		return $result;
	}
	public function restore()
	{   //soft delete undo's
		$result = parent::restore();

		if(env('CACHE_DRIVER') <> 'redis'){
			Cache::store('array')->tags(Config::get('entrust.permission_role_table'))->flush();
		} else {
			Cache::tags(Config::get('entrust.permission_role_table'))->flush();
		}
		return $result;
	}

}