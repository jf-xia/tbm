<?php

namespace App\Repositories;

use App\Models\BentityAttrSet;
use App\Repositories\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
use App\Models\Tasktype;
use App\Models\Bentity;

class BenattrsetRepository extends BaseRepository implements CacheableInterface
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
        'bentity_id',
        'tasktypes_id',
        'create_at',
        'update_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return BentityAttrSet::class;
    }


//    public function getUserTaskTypeList()
//    {
//        $user = \Auth::user();
//        if(!$user->isAdmin()){//
////            [$user->id,$user->leader,0]
//            $user_ids = array_keys(\Auth::user()->getTeams($user->id,[$user->id=>$user->name]));
//            $user_ids[] = 0;
//            $user_ids[] = $user->leader;
////            $builder=$this->findWhereIn('user_id',$user_ids)->sortBy('user_id')->toArray();
//            $builder=$this->all()->whereIn('id',$user_ids)->sortBy('id')->toArray();
//        }else{
//            $builder=$this->all()->sortBy('id')->toArray();
//        }
//        $builder=array_column($builder,'name','id');
//        return $builder;
//    }

    public function getAttrSetList()
    {
        $taskTypeList=array_column($this->all()->sortBy('id')->toArray(),'bentity_id','id');
        return $taskTypeList;

    }
    //取得业务库名称
    public function getBentityList(){
        $getBentityList=array_column(Bentity::all()->sortBy('id')->toArray(),'name','id');
        return $getBentityList;
    }
    //取得任务类型
    public function getTasktypeList(){
        $getTasktypeList=array_column(Tasktype::all()->sortBy('id')->toArray(),'name','id');
        return $getTasktypeList;
    }

}
