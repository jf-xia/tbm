<?php namespace App\Repositories;

use App\Repositories\Criteria\User\UsersWithRoles;
use App\User;
use App\Repositories\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

class UserRepository extends BaseRepository  //implements CacheableInterface
{
    //	protected $cacheMinutes = 90;

//    protected $cacheOnly = ['all','paginate'];
//    //or   all, paginate, find, findByField, findWhere, getByCriteria
//    protected $cacheExcept = ['find'];

    //	use CacheableRepository;

    // protected $fieldSearchable = [
    //         'name'=>'like',
    //         'email'=>'like'
    // ];

    public function model()
    {
        return User::class;
    }

    public function findWhereLike($where, $columns = ['*'], $or = false)
    {
        $this->applyCriteria();

        $model = $this->model;

        foreach ($where as $field => $value) {
            if ($value instanceof \Closure) {
                $model = (!$or)
                    ? $model->where($value)
                    : $model->orWhere($value);
            } elseif (is_array($value)) {
                if (count($value) === 3) {
                    list($field, $operator, $search) = $value;
                    $model = (!$or)
                        ? $model->where($field, $operator, $search)
                        : $model->orWhere($field, $operator, $search);
                } elseif (count($value) === 2) {
                    list($field, $search) = $value;
                    $model = (!$or)
                        ? $model->where($field, 'Like', '%'.$search.'%')
                        : $model->orWhere($field, 'Like', '%'.$search.'%');
                }
            } else {
                $model = (!$or)
                    ? $model->where($field, 'Like', '%'.$value.'%')
                    : $model->orWhere($field, 'Like', '%'.$value.'%');
            }
        }
        return $model->get($columns);
    }
}
