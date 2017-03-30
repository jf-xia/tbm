<?php namespace App\Repositories\Criteria\Permission;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class PermissionsWithRoles implements  CriteriaInterface {


	/**
	 * @param $model
	 * @param Repository $repository
	 *
	 * @return mixed
	 */
	public function apply( $model, RepositoryInterface $repository )
	{
		$model = $model->with('roles');
		return $model;
	}

}
