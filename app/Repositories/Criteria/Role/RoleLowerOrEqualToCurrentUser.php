<?php namespace App\Repositories\Criteria\Role;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;
use Illuminate\Contracts\Auth\Guard;

class RoleLowerOrEqualToCurrentUser implements  CriteriaInterface {

	public function __construct($user)
	{
		$this->user = $user;
	}

	/**
	 * @param $model
	 * @param Repository $repository
	 *
	 * @return mixed
	 */
	public function apply( $model, RepositoryInterface $repository )
	{
		$model = $model->where('level', '<=', $this->user->getLevelMax());
		return $model;
	}

}
