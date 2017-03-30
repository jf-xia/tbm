<?php

namespace App\Repositories;

use App\Models\Tasktype;
use App\Repositories\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

class TasktypeRepository extends BaseRepository implements CacheableInterface
{
    protected $cacheMinutes = 90;

//    protected $cacheOnly = ['all','paginate'];
//    //or   all, paginate, find, findByField, findWhere, getByCriteria
//    protected $cacheExcept = ['find'];

    use CacheableRepository;
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'color',
        'assigned_to',
        'user_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Tasktype::class;
    }

    public function getUserTaskTypeList()
    {
        $user = \Auth::user();
        if(!$user->isAdmin()){//
//            [$user->id,$user->leader,0]
            $user_ids = array_keys(\Auth::user()->getTeams($user->id,[$user->id=>$user->name]));
            $user_ids[] = 0;
            $user_ids[] = $user->leader;
//            $builder=$this->findWhereIn('user_id',$user_ids)->sortBy('user_id')->toArray();
            $builder=$this->all()->whereIn('user_id',$user_ids)->sortBy('user_id')->toArray();
        }else{
            $builder=$this->all()->sortBy('user_id')->toArray();
        }
        $builder=array_column($builder,'name','id');
        return $builder;
    }

    public function getTaskTypeList()
    {
        $taskTypeList=array_column($this->all()->sortBy('user_id')->toArray(),'name','id');
        return $taskTypeList;
    }
}
