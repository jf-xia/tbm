<?php
namespace App\Repositories\Criteria\Task;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class TasksByType implements CriteriaInterface  {

	private $typeId;

	public function __construct($typeId)
	{
		$this->typeId = $typeId;
	}

	/**
	 * @param $model
	 * @param Repository $repository
	 *
	 * @return mixed
	 */
	public function apply($model, RepositoryInterface $repository )
	{
		$model = $model->where('tasktype_id',$this->typeId);
		return $model;
	}

}
