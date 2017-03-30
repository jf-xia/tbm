<?php namespace App\Repositories;


use App\Repositories\Criteria\Role\RolesWithPermissions;
use App\Models\Role;
use App\Repositories\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

class RoleRepository extends BaseRepository  implements CacheableInterface
{
	protected $cacheMinutes = 90;

//    protected $cacheOnly = ['all','paginate'];
//    //or   all, paginate, find, findByField, findWhere, getByCriteria
    protected $cacheExcept = [];

	use CacheableRepository;

	public function model()
	{
		return Role::class;
	}

}