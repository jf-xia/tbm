<?php

namespace App\Repositories;

use App\Models\Taskstatus;
use App\Repositories\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

class TaskstatusRepository extends BaseRepository implements CacheableInterface
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
        'user_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Taskstatus::class;
    }

    public function selectTaskstatus(){
        $user = \Auth::user();
        if(!$user->isAdmin()){//
//            $builder=$this->findWhereIn('user_id',[$user->id,$user->leader,0])->sortBy('user_id')->toArray();
            $builder=$this->all()->whereIn('user_id',[$user->id,$user->leader,0])->sortBy('user_id')->toArray();
        }else{
            $builder=$this->all()->sortBy('user_id')->toArray();
        }
        $builder=array_column($builder,'name','id');
        return $builder;
//        return array_column(\App\Models\Taskstatus::all('name','id')->toArray(),'name','id');
    }

}
