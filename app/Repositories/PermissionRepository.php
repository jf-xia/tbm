<?php namespace App\Repositories;

use App\Models\Permission;
use App\Repositories\Criteria\Permission\PermissionsWithRoles;
use App\Repositories\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

class PermissionRepository extends BaseRepository  implements CacheableInterface
{
	protected $cacheMinutes = 90;

//    protected $cacheOnly = ['all','paginate'];
//    //or   all, paginate, find, findByField, findWhere, getByCriteria
	protected $cacheExcept = [];

	use CacheableRepository;


	public function model()
	{
		return Permission::class;
	}

}