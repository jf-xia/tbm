<?php

namespace App\Repositories;

use App\Models\BentityUser;
use App\Repositories\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
use App\Models\Tasktype;
use App\Http\Controllers\Auth\UsersController;

class BentityuserRepository extends BaseRepository implements CacheableInterface
{
    protected $cacheMinutes = 90;

//    protected $cacheOnly = ['all','paginate'];
//    //or   all, paginate, find, findByField, findWhere, getByCriteria
//    protected $cacheExcept = ['find'];

    use CacheableRepository;

    protected $fieldSearchable = [
        'user_id',
        'tasktypes_id',
        'create_at',
        'update_at'
    ];


    /**
     * Configure the Model
     **/
    public function model()
    {
        return BentityUser::class;
    }




//    public function getBentityUserList()
//    {
//        $getBentityUserList=array_column($this->all()->sortBy('id')->toArray(),'user_id','id');
//        return $getBentityUserList;
////        $user = \Auth::user();
//    }
//    //取得业务库名称
//    public function getBentityList(){
//        $getBentityList=array_column(Bentity::all()->sortBy('id')->toArray(),'name','id');
//        return $getBentityList;
//    }
//    //取得任务类型
    public function getTasktypeList(){
        $getTasktypeList=array_column(Tasktype::all()->sortBy('id')->toArray(),'name','id');
        return $getTasktypeList;
    }
 public function getUserList(){
//     return $this->belongsTo(\Auth::user(),'user_id','id');
     $getUserList=array_column(\Auth::user()->all()->sortBy('id')->toArray(),'name','id');
     return $getUserList;
 }
}
