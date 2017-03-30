<?php
namespace App\Repositories\Criteria\User;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class UsersWithRoles implements CriteriaInterface  {


	/**
	 * @param $model
	 * @param Repository $repository
	 *
	 * @return mixed
	 */
	public function apply($model, RepositoryInterface $repository )
	{
		$model = $model->with('roles')->where('leader','=',\Auth::id());
		return $model;
	}

}
