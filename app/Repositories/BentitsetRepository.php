<?php

namespace App\Repositories;

use App\Models\BentitSet;
use App\Repositories\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;


class BentitsetRepository extends BaseRepository implements CacheableInterface
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
        'task_id',
        'ben_title_id',
        'create_at',
        'update_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return BentitSet::class;
    }

//    获取tasks列表。以array输出
    public function getTaskList($id)
    {
        $getTaskList=null;
        if ($id){
         $getTaskList = $this->findWhere(['ben_title_id'=>$id])->sortByDesc('created_at');
       }

        if ($this->findWithoutFail($id)){
            $task = $this->findWithoutFail($id);
            $getTaskList[]=$task;
        }
        return $getTaskList;
    }


}
