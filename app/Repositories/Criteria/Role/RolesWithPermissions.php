<?php namespace App\Repositories\Criteria\Role;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class RolesWithPermissions implements CriteriaInterface {


	/**
	 * @param $model
	 * @param Repository $repository
	 *
	 * @return mixed
	 */
	public function apply( $model, RepositoryInterface $repository )
	{
		$model = $model->with('perms');
		return $model;
	}

}
